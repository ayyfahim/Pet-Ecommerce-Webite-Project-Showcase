import styles from 'styles/InstagramFollow.module.scss';
import InstagramCard from 'components/InstagramCard';

export default function InstagramFollow({ homepageData, feed }) {
  return (
    <div>
      <div className={styles.photosSection}>
        <div className={styles.photosWrapper}>
          {feed
            ? feed?.map((e, i) => <InstagramCard key={`${i}_card_inst`} link={e?.permalink} img={e?.url} />)
            : [...Array(10)].map((e, i) => (
                <InstagramCard
                  key={`${i}_card_inst`}
                  link="https://www.instagram.com"
                  img="/img/follow-instagram/ig-photo-1@2x.webp"
                />
              ))}
          {[...Array(10)].map((e, i) => (
            <InstagramCard
              key={`${i}_card_inst`}
              link="https://www.instagram.com"
              img="/img/follow-instagram/ig-photo-1@2x.webp"
            />
          ))}
        </div>
      </div>
      <div className={styles.followUs}>
        <div className="container mx-auto">{`${homepageData?.instagram_section_text ?? 'Follow us on instagram'} ${
          homepageData?.instagram_section_username ?? '@vitalpawz'
        }`}</div>
      </div>
    </div>
  );
}
