import styles from 'styles/BlogCard.module.scss';
import { FC } from 'react';
import Link from 'next/link';
import classnames from 'classnames';

interface BlogCardProps {
  image?: string;
  title?: string;
  description?: string;
  date?: string;
  id?: string;
  slug: string;
  big?: boolean;
  related?: boolean;
}

const BlogCard: FC<BlogCardProps> = ({ image, title, description, date, id, slug, big, related }) => {
  const classBlog = classnames(styles.blog, {
    [styles.big]: big,
    [styles.related]: related,
  });
  return (
    <Link href={`/blogs/${slug}`}>
      <a>
        <div className={classBlog}>
          <div className={styles.imgContainer}>
            <img
              className="h-full w-full object-cover"
              src={image ? image : ''}
              alt={title ? `${title} img` : 'Img of blog'}
            />
          </div>
          <div className={styles.blogText}>
            <span className={styles.blogDate}>{date ? date : '_'}</span>
            <h4 title={title ? title : '_'} className={styles.blogTitle}>
              {title ? title : '_'}
            </h4>
            <div className={styles.blogExcerpt}>
              <p>{description ? description : '_'}</p>
              {description && <button className={styles.readMore}>Read More</button>}
            </div>
          </div>
        </div>
      </a>
    </Link>
  );
};

export default BlogCard;
