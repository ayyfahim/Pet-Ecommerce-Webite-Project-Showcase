import React from 'react'
import style from './RewardInput.module.scss';

const RewardCodeInput = () => {
  return (
    <div className={style.RewardInputWrapper}>
      <input placeholder='Gift card or discount code' type="text" /> 
      <button>Apply</button>
    </div>
  )
}

export default RewardCodeInput