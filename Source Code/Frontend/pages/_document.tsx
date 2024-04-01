import Document, { Html, Main, NextScript, DocumentContext, Head } from 'next/document';

export default class MyDocument extends Document {
  static async getInitialProps(ctx: DocumentContext) {
    const initialProps = await Document.getInitialProps(ctx);

    const { renderPage } = ctx;
    const originalRenderPage = renderPage;

    try {
      ctx.renderPage = () =>
        originalRenderPage({
          enhanceApp(App) {
            // eslint-disable-next-line react/display-name
            return (props) => {
              props.pageProps.isServerRendered = Boolean(ctx.req);
              return <App {...props} />;
            };
          },
        });

      const initialProps = await Document.getInitialProps(ctx);

      return {
        ...initialProps,
        isServerRendered: !!ctx.req,
      };
    } finally {
      //
    }

    return {
      ...initialProps,
    };
  }

  render() {
    return (
      <Html lang="en">
        <Head />
        <body>
          <Main />
          <NextScript />
        </body>
      </Html>
    );
  }
}
