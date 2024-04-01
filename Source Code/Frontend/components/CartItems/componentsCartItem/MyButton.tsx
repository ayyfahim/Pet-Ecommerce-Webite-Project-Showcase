import React, { FC } from 'react'
import styles from './MyButton.module.scss';
import Image from "next/image";
import plus from '../images/iconPlusIcn.png'
import minus from '../images/iconMinusIcn.png'

interface myButtonProps {
  mode: string,
  handle: () => void
}

const MyButton: FC<myButtonProps> = ({handle, mode}) => {
  return (
    <button className={styles.btn} onClick={handle}><Image src={mode === 'plus' ? plus : minus} alt={mode === 'plus' ? 'plus' : 'minus'} /></button>
  )
}
export default MyButton;