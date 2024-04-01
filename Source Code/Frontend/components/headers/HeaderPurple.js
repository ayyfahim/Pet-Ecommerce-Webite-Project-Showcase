import styles from 'styles/headers/HeaderPurple.module.css'

export default function HeaderPurple({ heading, description }) {
  return (
    <div className={styles.wrapper}>
      <div className="container mx-auto px-4">
        <h1 className={styles.heading}>{ heading }</h1>
        <p className={styles.description}>{ description }</p>
      </div>
    </div>
  )
}