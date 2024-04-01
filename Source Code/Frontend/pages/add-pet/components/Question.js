import style from 'styles/AddPet.module.scss';
import { useFormContext } from 'react-hook-form';

const Question = ({ children, q, q_no, name, length, sub_title, ...props }) => {
  const { getValues } = useFormContext() || {};
  return (
    <div {...props}>
      <span className={style.qSubHeading}>
        Question{' '}
        <b>
          {q_no} 0f {length}
        </b>
      </span>
      {sub_title ? (
        <div className="flex flex-row justify-between">
          <h4 className={style.qMainHeading}>{q}</h4>
          <span className="text-xl text-purple font-bold">
            {getValues(name)} {sub_title}
          </span>
        </div>
      ) : (
        <h4 className={style.qMainHeading}>{q}</h4>
      )}

      {children}
    </div>
  );
};

export default Question;
