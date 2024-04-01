import { postRequest } from '@/app/requests/api';
import axios from 'axios';
import { getEnv } from '@/bootstrap/app.config';

export default async function handler(req, res) {
  const captchaSecretKey = getEnv('captchaSecretKey', '6Ld7jVQmAAAAADVob80WOhxZ-_NFmgnxwgu03DNu');

  const response = await axios.post(
    `https://www.google.com/recaptcha/api/siteverify?secret=${captchaSecretKey}&response=${req.body.token}`
  );

  // Check response status and send back to the client-side
  if (!response.data.success) {
    return res.status(400).json({
      message: 'Invalid Token.',
    });
  }

  postRequest(`/contact_us`, {
    email: req.body.email,
    full_name: req.body.full_name,
    message: req.body.message,
    mobile: req.body.contact_number,
  })
    .then(() => {
      return res.status(200).json({ message: 'Your message has been sent successfully!' });
    })
    .catch(({ error }) => {
      return res.status(400).json(error?.response?.data);
    });
}
