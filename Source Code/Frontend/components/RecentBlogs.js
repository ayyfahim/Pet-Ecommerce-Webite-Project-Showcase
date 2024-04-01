import styles from '../styles/RecentBlogs.module.css';
import Image from 'next/image';
import blogImageOne from 'public/img/recent-blogs/blog-image-1@2x.webp';
import { useEffect, useState } from 'react';
import Link from 'next/link';

const skeletonCards = Array(3).fill(0);

export default function RecentBlogs({ recentBlogs, homepageData }) {
  const [mounted, setMounted] = useState(false);
  useEffect(() => {
    setMounted(true);
  }, []);
  if (!mounted) return null;
  return (
    <div className={styles.wrapper}>
      <h2 className={styles.heading}>{homepageData?.blogs_section_header ?? 'Recent Blogs'}</h2>
      <p className={styles.description}>
        {homepageData?.blogs_section_desctiption ??
          'Any parent will tell you that colic is one of the most excruciating experiences of early parenthood. The baby cries as if in dire pain.'}
      </p>
      <div className={styles.blogs}>
        {recentBlogs
          ? recentBlogs?.map(({ id, created_at, title, content, slug, cover }) => (
              <Link href={`/blogs/${slug}`}>
                <div key={id} className={styles.blog}>
                  <Image alt="logo" src={cover} width={390} height={215} />
                  <span className={styles.blogDate}>{created_at}</span>
                  <h4 className={styles.blogTitle}>{title}</h4>
                  <div className={styles.blogExcerpt}>
                    <div className={styles.blogExcerptContent} dangerouslySetInnerHTML={{ __html: content }}></div>
                    <button className={styles.readMore}>Read More</button>
                  </div>
                </div>
              </Link>
            ))
          : skeletonCards.map((item, index) => <SkeletonCard index={index} />)}
      </div>
    </div>
  );
}

const SkeletonCard = (props) => {
  return (
    <div className={styles.blog}>
      <div className="md:w-[390px] w-[253px] md:h-[215px] h-[140px] animate-pulse bg-gradient-to-r from-gray-400 to-gray-500"></div>
      <div className={`w-[100px] h-[25px] animate-pulse rounded-md bg-gray-400 mx-18px ${styles.blogDate}`}></div>
      <div
        className={`md:w-[300px] w-[150px] h-[40px] animate-pulse rounded-md bg-gray-400 mx-18px mt-7px ${styles.blogTitle}`}
      ></div>

      <div className={styles.blogExcerpt}>
        <div
          className={`md:w-[340px] w-[200px] h-[120px] animate-pulse rounded-md bg-gray-400 mt-7px ${styles.blogExcerptContent}`}
        ></div>
        <div className={`w-[100px] h-[25px] animate-pulse rounded-md bg-pink mt-7px ${styles.readMore}`}></div>
      </div>
    </div>
  );
};
