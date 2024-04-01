<?php
/**
 * Created by PhpStorm.
 * User: Road9-2
 * Date: 7/28/2020
 * Time: 11:08 AM
 */

namespace App\Http\Controllers\Traits\Product;


use Google\Spreadsheet\DefaultServiceRequest;
use Google\Spreadsheet\Exception\SpreadsheetNotFoundException;
use Google\Spreadsheet\Exception\WorksheetNotFoundException;
use Google\Spreadsheet\ListEntry;
use Google\Spreadsheet\ListFeed;
use Google\Spreadsheet\ServiceRequestFactory;
use Google\Spreadsheet\Spreadsheet;
use Google\Spreadsheet\SpreadsheetService;
use Google_Client;

trait GoogleSheets
{
    /**
     * @throws SpreadsheetNotFoundException
     */
    private function getSpreadSheet()
    {
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . __DIR__ . '/ts-service-account.json');
        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->setApplicationName("Products");
        $client->setScopes(['https://www.googleapis.com/auth/drive', 'https://spreadsheets.google.com/feeds']);
        if ($client->isAccessTokenExpired()) {
            $client->refreshTokenWithAssertion();
        }
        $accessToken = $client->fetchAccessTokenWithAssertion()["access_token"];
        ServiceRequestFactory::setInstance(
            new DefaultServiceRequest($accessToken)
        );
        return (new SpreadsheetService())
            ->getSpreadsheetFeed()
            ->getByTitle('Products_Data_Admin');
    }

    /**
     * @param Spreadsheet $spreadsheet
     * @param $sheet_title
     * @return ListFeed
     * @throws WorksheetNotFoundException
     */
    private function getSheet(Spreadsheet $spreadsheet, $sheet_title)
    {
        return $spreadsheet->getWorksheetFeed()->getByTitle($sheet_title)->getListFeed();
    }

    /**
     * @param $sheet_title
     * @param array $data
     * @throws SpreadsheetNotFoundException
     * @throws WorksheetNotFoundException
     */
    private function insert($sheet_title, array $data)
    {
        $spreadsheet = $this->getSpreadSheet();
        $sheet = $this->getSheet($spreadsheet, $sheet_title);
        foreach ($data as $item) {
            try {
                $sheet->insert($item);
            } catch (\Exception $exception) {
                dd($item);
            }
        }
    }

    /**
     * @param $sheet_title
     * @return ListEntry[]
     * @throws SpreadsheetNotFoundException
     * @throws WorksheetNotFoundException
     */
    private function fetch($sheet_title)
    {
        $spreadsheet = $this->getSpreadSheet();
        return $this->getSheet($spreadsheet, $sheet_title)->getEntries();
    }
}
