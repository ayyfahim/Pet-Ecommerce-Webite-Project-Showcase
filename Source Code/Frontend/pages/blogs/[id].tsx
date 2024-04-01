import React from 'react';
import createGetServerSidePropsFn from 'shared/createGetServerSidePropsFn';
import MainLayout from 'layouts/MainLayout';
import style from 'styles/BlogPage.module.scss';
import BlogCard from '@/components/BlogCard';
import { getRequest } from '@/app/requests/api';
import Error from 'next/error';

const description =
  'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius dolorem labore explicabo odio nostrum dignissimos error facere, blanditiis modi qui aliquam obcaecati! Labore commodi quasi cupiditate porro excepturi natus doloremque sunt. Ea corrupti non facilis ratione quas totam, delectus omnis laborum veritatis repudiandae numquam nihil laudantium, iste aperiam nisi eaque alias voluptate odio deserunt exercitationem, aut animi nobis dolore? Deleniti minima rem quibusdam, neque mollitia obcaecati deserunt adipisci excepturi provident autem saepe placeat voluptatem hic natus ipsa facilis aliquam sint nam consequatur quo? Ratione ad quos vitae, corrupti veniam vero sit qui rem aspernatur accusamus harum amet dolorum exercitationem minima.';

interface IRelatedPostsMock {
  image: string;
  title: string;
  description: string;
  date: string;
  id: number;
}

const relatedPostsMock: IRelatedPostsMock[] = [
  {
    image: '../img/blogPage/img1.png',
    title: 'Dog Winter Care with HUFT',
    description,
    date: 'October 27, 2021',
    id: 1,
  },
  {
    image: '../img/blogPage/img2.png',
    title: 'Dog Winter Care with HUFT',
    description,
    date: 'October 27, 2021',
    id: 2,
  },
  {
    id: 3,
    image: '../img/blogPage/img3.png',
    title: 'Pros and Cons of Maltipoo Ownership – Should You Get',
    description,
    date: 'October 27, 2021',
  },
];

const Id = ({ blogResponse }: { blogResponse: any }) => {
  const article = blogResponse.article;
  const related_articles = blogResponse.related_articles;

  if (!article) {
    return <Error statusCode={404} />;
  }
  return (
    <div className={style.blogPage}>
      <div className={style.blogPageLayout}>
        <div className={style.blogPageHeaderWrapper}>
          <h2>{article?.title}</h2>
        </div>
        <div className={style.publishedInfo}>
          <span>
            Published on <b>{article?.created_at}</b>
          </span>
          <span>
            {' '}
            by <b>{article?.author.name}</b>
          </span>
        </div>
        <div className={style.mainImgSmallScreen}>
          <img src={article?.cover} alt="mainImg" />
        </div>
        <div className={style.mainImg}>
          <img src={article?.cover} alt="mainImg" />
        </div>
        <div className={style.BlogPageText} dangerouslySetInnerHTML={{ __html: article?.content }}></div>
        <div className={style.BlogPageAuthorCart}>
          <div className={style.BlogPageAuthorCartImg}>
            <img src={article?.author?.avatar ?? '../../img/blogPage/avatarImg.png'} alt="author" />
          </div>
          <div className={style.BlogPageAuthorCartContent}>
            <h3>
              Published by <mark>{article?.author?.name}</mark>
            </h3>
            <p>{article?.author?.bio?.slice(0, 176)}</p>
          </div>
        </div>
      </div>
      <div className={style.RelatedBlogs}>
        <div className={style.RelatedBlogsWrapper}>
          <h2>Related Blogs</h2>
          <div className={style.RelatedBlogsCards}>
            {related_articles?.map((post: any) => (
              <BlogCard
                related={true}
                key={post.id}
                id={post.id}
                slug={post.slug}
                title={post.title}
                description={post.excerpt}
                date={post.created_at}
                image={post.cover}
              />
            ))}
          </div>
        </div>
      </div>
    </div>
  );
};

export const getServerSideProps = createGetServerSidePropsFn(Id, async ({ params }) => {
  const response = await getRequest(`/articles/${params?.id}`);
  if (!response || !response?.article) {
    return {
      notFound: true,
    };
  }
  return {
    props: {
      blogResponse: response || [],
    },
  };
});
Id.Layout = MainLayout;

export default Id;
