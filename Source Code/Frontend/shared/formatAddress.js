const formatAddress = (address) => {
  // {
  //   `${address?.street_address ?? ''}${address?.city ? ', ' + address?.city : ''}${
  //     address?.country ? ', ' + address?.country : ''
  //   }${address?.postal_code ? ', ' + address?.postal_code : ''}`;
  // }

  const formattedAddressArray = [address?.street_address, address?.city, address?.country, address?.postal_code];
  const formattedAddressString = formattedAddressArray?.filter((i) => i)?.join(', ');

  return formattedAddressString;
};

export default formatAddress;
