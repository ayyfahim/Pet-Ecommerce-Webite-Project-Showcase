<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\FileAdder\FileAdder;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * https://docs.spatie.be/laravel-medialibrary/v7/responsive-images/getting-started-with-responsive-images.
 */
trait HasMedia
{
    use HasMediaTrait;

    public $registerMediaConversionsUsingModelInstance = true;

    /**
     * https://docs.spatie.be/laravel-medialibrary/v7/working-with-media-collections/defining-media-collections.
     */
    public function registerMediaCollections()
    {
        $this->addMediaCollection('avatar')->singleFile();
        $this->addMediaCollection('badge')->singleFile();
        $this->addMediaCollection('cover')->singleFile();
        $this->addMediaCollection('icon')->singleFile();
        $this->addMediaCollection('banner')->singleFile();
    }

    /**
     * https://docs.spatie.be/laravel-medialibrary/v7/converting-images/defining-conversions.
     *
     * @param Media $media
     */
    public function registerMediaConversions(Media $media = null)
    {
        // https://docs.spatie.be/laravel-medialibrary/v5/converting-images/defining-conversions/#performing-conversions-on-specific-collections


        $this->addMediaConversion('optimized')
            ->width(800)
            ->withResponsiveImages()
            ->performOnCollections('gallery', 'cover', 'avatar', 'badge')
            ->keepOriginalImageFormat();

        $this->addMediaConversion('thumb')
            ->width(120)
            ->height(120)
            ->sharpen(10)
            // ->withResponsiveImages()
            ->performOnCollections('gallery', 'avatar', 'badge', 'cover');
    }

    /**
     * away around of having to explicitly
     * set the saved file name of each upload.
     *
     * now just use "addHashedMedia()" instead of the
     * original "addMedia()" and chain like usual
     *
     * @param $file
     * @param bool $import
     * @param array $custom
     * @return FileAdder
     */
    public function addHashedMedia($file, $import = false, $custom = [])
    {
        $name = time();
        if ($import) {
            $ext = pathinfo($file, PATHINFO_EXTENSION);
        } else {
            $ext = $file->getClientOriginalExtension();
        }
        return $this->addMedia($file)
            ->usingName($name)
            ->withCustomProperties($custom)
            ->usingFileName("$name.$ext");
    }

    public function addHashedMediaFromUrl($url, $custom = [])
    {
        try {
            return $this->addMediaFromUrl($url)
                ->withCustomProperties($custom);
        } catch (FileCannotBeAdded $e) {
        }
    }

    /**
     * helper to get url for a media instance.
     *
     * @param [type] $item
     * @param mixed $thumb
     * @param mixed $conversion
     */
    public function getUrlFor($item, $conversion = '')
    {
        $media = $this->{$item};

        return $media ? $media->getUrl($conversion) : null;
    }
}
