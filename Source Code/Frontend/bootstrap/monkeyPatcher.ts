const camelCaseToWords = function (str: string) {
  return (
    (str || '')
      .match(/^[a-z]+|[A-Z][a-z]*/g)
      ?.map(function (x) {
        return x[0].toUpperCase() + x.substr(1).toLowerCase();
      })
      ?.join(' ') ||
    str ||
    ''
  );
};

String.prototype.convertToReadable = function () {
  const str = camelCaseToWords((this || '') as string);
  return str.replace(/(_|-)/g, ' ');
};

String.prototype.toSnakeCase = function (useDashSeparator = false) {
  return this.convertToReadable()
    .toLowerCase()
    .replace(/\s/g, useDashSeparator ? '-' : '_');
};

String.prototype.toPascalCase = function () {
  return this.convertToReadable().capitalize().replace(/(\s)/g, '');
};

String.prototype.toCamelCase = function () {
  const str = this.toPascalCase();
  return str.charAt(0).toLowerCase() + str.slice(1);
};

String.prototype.capitalize = function (humanReadable = true) {
  return (humanReadable ? this.toLowerCase() : this).replace(/(?:^|\s|["'([{])+\S/g, (match) => match.toUpperCase());
};

// @ts-ignore
String.prototype.excerpt = function (length = (this as string).length, append = '...') {
  if (this.length > length) {
    return this.slice(0, length - append.length) + append;
  }
  return this.slice(0, length);
};

String.prototype.slugify = function () {
  // eslint-disable-next-line @typescript-eslint/no-this-alias
  let str = this as string;
  str = str.replace(/^\s+|\s+$/g, ''); // trim
  str = str.toLowerCase();

  // remove accents, swap ñ for n, etc
  const from = 'àáäâèéëêìíïîòóöôùúüûñç·/_,:;';
  const to = 'aaaaeeeeiiiioooouuuunc------';
  for (let i = 0, l = from.length; i < l; i++) {
    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
  }

  str = str
    .replace(/[^a-z0-9 -]/g, '') // remove invalid chars
    .replace(/\s+/g, '-') // collapse whitespace and replace by -
    .replace(/-+/g, '-'); // collapse dashes

  return str;
};

Number.prototype.currency = function (precision = 2) {
  const value = this as number;
  const data = `${this}`.split('.');
  if (data.length > 1) {
    if (data[1].replace(/0/g, '') === '') {
      return parseInt(data[0]);
    }
    if (precision === 0) {
      return Math.trunc(value as number);
    }
    if (precision) {
      return parseFloat(value.toFixed(precision));
    }
    return parseFloat(`` + value);
  }
  return parseFloat(`` + value);
};

String.prototype.currency = function (precision = 2) {
  const value = parseFloat(this as string);
  if (isNaN(value)) {
    return 0;
  }
  return value.currency(precision);
};

export {};
