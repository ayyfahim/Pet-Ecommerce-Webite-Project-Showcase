/* eslint-disable no-process-env */
/**
 *
 * @param str {string}
 * @returns {string}
 */

const envConfig = {
  apiUrl: process.env.NEXT_PUBLIC_API_URL,
  nodeEnv: process.env.NEXT_PUBLIC_NODE_ENV || 'production',
  appUrl: process.env.NEXT_PUBLIC_APP_URL || 'http://localhost:3000',
  stripeKey: process.env.NEXT_PUBLIC_STRIPE_KEY || ' ',
  bugherdKey: process.env.NEXT_PUBLIC_STRIPE_KEY,
  fbAppId: process.env.NEXT_PUBLIC_FB_APP_ID || ' ',
  googleAppId: process.env.NEXT_PUBLIC_GOOGLE_APP_ID || ' ',
  googleMapKey: process.env.NEXT_PUBLIC_GOOGLE_ADDRESS_KEY || ' ',
  captchaSiteKey: process.env.NEXT_PUBLIC_GOOGLE_CAPTCHA_SITE_KEY || '6Ld7jVQmAAAAAKdWTwaF7bguHS2OcQ_B7zmFesma',
  captchaSecretKey: process.env.NEXT_PUBLIC_GOOGLE_CAPTCHA_SECRET_KEY || '6Ld7jVQmAAAAADVob80WOhxZ-_NFmgnxwgu03DNu',
};

const requiredEnvConfig = {
  apiUrl: true,
  fbAppId: true,
  googleAppId: true,
};

module.exports = {
  envConfig,
  requiredEnvConfig,
};
