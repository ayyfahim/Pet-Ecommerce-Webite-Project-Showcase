declare module '*.svg' {
  const content: React.FunctionComponent<React.SVGAttributes<SVGElement>>;
  export default content;
}

declare global {
  interface Number {
    currency(precision?: number): number;
  }

  interface String {
    convertToReadable(): string;
    stripTags(): string;
    toCamelCase(): string;
    capitalize(humanReadable?: boolean): string;
    toSnakeCase(useDashSeparator = false): string;
    toPascalCase(): string;
    slugify(): string;
    excerpt(limit?: number, trail?: string): string;
    hexToRGB(): string;
    currency(precision?: number): number;
  }
}

export {};
