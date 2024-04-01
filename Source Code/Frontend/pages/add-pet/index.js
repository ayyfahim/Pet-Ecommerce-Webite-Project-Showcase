import AuthLayout from 'layouts/Auth2.layout';
import createGetServerSidePropsFn from 'shared/createGetServerSidePropsFn';
import MySelect from './components/MySelectL';
import RangeSlider from './components/MyRangeSlider';
import Question from './components/Question';
import MyInputL from './components/MyInputL';
import ImgOption from './components/ImgOption';
import BlockOption from './components/BlockOption';
import FormControl, { FormControlName } from './components/FormControl';
import style from 'styles/AddPet.module.scss';
import PrimarySmall from 'components/Buttons/PrimarySmall';
import useWindowDimensions from '@/app/hooks/useWindowDimensions';
import { useForm, FormProvider } from 'react-hook-form';
import React, { useState, useEffect } from 'react';
import classNames from 'classnames';
import { number, object, string, array } from 'yup';
import { yupResolver } from '@hookform/resolvers/yup';
import { useRouter } from 'next/router';
import { getRequest } from 'requests/api';
import { useRcmState } from 'app/atom/recommendProducts.atom';

const formSchema = object().shape({
  petConcern: array('An error occurred.')
    .of(string())
    .label('Pet Concern')
    .required('This field is required.')
    .min(1, 'Please select an option.'),
  petName: string('This field must be a text.').label('Pet Name').required('This field is required.'),
  selectPet: string('This field must be a text.').label('Pet').required('This field is required.'),
  selectBreed: object().typeError('Please select an option.').label('Breed').required('This field is required.'),
  petAge: number('Age must be a number')
    .typeError('Age must be a number')
    .label('Pet Age')
    .required('This field is required.')
    .moreThan(0, 'Age must be more than 0'),
  // petWeight: number('Weight must be a number.')
  //   .typeError('Weight must be a number')
  //   .label('Pet Weight')
  //   .required('This field is required.')
  //   .moreThan(0, 'Weight must be more than 0'),
});

const defaultValues = {
  petAge: 0,
  petConcern: [],
  petName: '',
  // petWeight: '',
  selectBreed: null,
  selectPet: '',
};

const questions = [
  {
    no: 1,
    title: 'What is the name of your pet?',
    name: 'petName',
  },
  {
    no: 2,
    title: 'What pet do you have?',
    name: 'selectPet',
  },
  {
    no: 3,
    title: 'And what breed?',
    name: 'selectBreed',
  },
  {
    no: 4,
    title: 'How old is Kenny?',
    sub_title: ' years',
    name: 'petAge',
  },
  {
    no: 5,
    title: 'What is the major concerns?',
    name: 'petConcern',
  },
];

const QuestionItems = ({ name, width, handleNextStepButton, concerns, pets, breeds, ...props }) => {
  {
    switch (name) {
      case 'petName':
        return <MyInputL placeholder="Type Name..." {...props} />;
        break;

      case 'selectPet':
        return (
          <div className="flex flex-row flex-wrap mt-20px">
            {pets?.map((item, index) => (
              <ImgOption
                width={width}
                item={item}
                index={index}
                handleNextStepButton={handleNextStepButton}
                {...props}
              />
            ))}
          </div>
        );
        break;

      case 'selectBreed':
        return (
          <MySelect
            optionsArr={breeds}
            classNamePrefix="mySelectL"
            searchPlaceholder="Search Breed"
            placeholder={'Search'}
            menuPosition={width > 1024 ? 'fixed' : 'absolute'}
            // menuShouldBlockScroll="true"
            menuShouldScrollIntoView="true"
            menuPlacement="auto"
            // handleNextStepButton={handleNextStepButton}
            {...props}
          />
        );
        break;

      case 'petAge':
        return <RangeSlider className="MyRangeSlider" tooltip={false} {...props} />;
        break;

      case 'petConcern':
        return concerns?.map((item, index) => (
          <BlockOption item={item} index={index} handleNextStepButton={handleNextStepButton} {...props} />
        ));
        break;

      default:
        return <></>;
        break;
    }
  }
};

const Questions = ({ question, width, handleNextStepButton, concerns, pets, breeds }) => {
  // const index = question - 1;
  // const q = questions[index];
  return questions?.map((q, index) => (
    <Question
      index={index}
      id={`question-${q.no}`}
      className={`py-31px ${style.question} ${question == q.no ? 'block' : 'hidden'} ${
        question == 5 ? 'pt-[100px] pb-[50px]' : ''
      }`}
      q={q.title}
      q_no={q.no}
      name={q.name}
      length={questions.length}
      sub_title={q.sub_title}
    >
      <FormControl>
        <FormControlName>{q.name}</FormControlName>
        <QuestionItems
          index={index}
          width={width}
          name={q.name}
          handleNextStepButton={handleNextStepButton}
          concerns={concerns}
          pets={pets}
          breeds={breeds}
        />
      </FormControl>
    </Question>
  ));
};

const AddPet = ({ concerns, pets }) => {
  const [rcm, setRcm] = useRcmState();
  const { push } = useRouter();
  const methods = useForm({ resolver: yupResolver(formSchema), defaultValues: defaultValues });

  const {
    trigger,
    formState: { errors },
    watch,
    control,
    getValues,
  } = methods;

  watch();

  const { width } = useWindowDimensions();

  const [isLoading, setIsLoading] = useState(false);
  const [question, setQuestion] = useState(1);
  const [breeds, setBreeds] = useState([]);

  const bodyHeightClass = classNames({
    [`${style.bodyWrapper}`]: true,
    'lg:h-[620px]': question < 6,
    'lg:h-[850px]': question >= 6,
  });

  const handleNextStepButton = async (e) => {
    if (isLoading) return;
    setIsLoading(true);
    const getQuestion = questions.filter((item) => item.no == question);

    // async function fetchData() {
    //   const response = await getRequest(`/product_recomeendation?pet_type_id=${getValues('selectPet')}`);
    //   const breedsResp = response?.breeds?.map((obj) => ({ ...obj, value: obj?.name, label: obj?.id }));
    //   setBreeds(breedsResp);
    // }

    // if (question == 3) {
    //   fetchData();
    // }

    if (getQuestion) {
      const { name, no } = getQuestion[0];
      const waitForValidate = await trigger(`${name}`);
      if (waitForValidate) {
        if (question == 2) {
          const response = await getRequest(`/product_recomeendation?pet_type_id=${getValues('selectPet')}`);
          const breedsResp = response?.breeds?.map((obj) => ({ ...obj, value: obj?.name, label: obj?.id }));
          setBreeds(breedsResp);
        }
        setQuestion((prev) => prev + 1);
      } else {
        const element = document.getElementById(`question-${no}`);
        element?.scrollIntoView({
          behavior: 'smooth',
          block: 'center',
        });
      }

      setIsLoading(false);
    }
  };

  const handleResultButton = async (e) => {
    const waitForValidate = await trigger();

    // console.log('rcm', rcm);
    // console.log('waitForValidate', waitForValidate);
    if (waitForValidate) {
      setRcm({
        petName: getValues('petName'),
        petTypeId: getValues('selectPet'),
        breedId: getValues('selectBreed')?.id,
        petAge: getValues('petAge'),
        concern: getValues('petConcern'),
      });
      // console.log('rcm', rcm);
      push('/add-pet/recommendation');
    }
  };

  useEffect(() => {
    const element = document.getElementById(`question-${question}`);
    element?.scrollIntoView({
      behavior: 'smooth',
      block: 'center',
    });
  }, [question]);

  useEffect(() => {
    const keyEnter = async (event) => {
      if (event.key === 'Enter') {
        if (width < 1024) {
          await handleResultButton();
        }
        if (question >= questions?.length) {
          await handleResultButton();
        } else {
          await handleNextStepButton();
        }
      }
    };

    document.addEventListener('keydown', keyEnter);

    return () => {
      document.removeEventListener('keydown', keyEnter);
    };
  }, [question, width]);

  return (
    <>
      <FormProvider {...methods}>
        <div className={`${style.bodyWrapper}`}>
          <div className={style.header}>
            <p className={style.title}>Product Recommendation</p>
            <p className={style.desc}>
              Unsure of what product is right for your pet, answer few questions and we will recommend you some
              products.
            </p>
          </div>

          <Questions
            question={question}
            width={width}
            handleNextStepButton={handleNextStepButton}
            concerns={concerns}
            pets={pets}
            breeds={breeds}
          />

          {width < 1024 && (
            <div>
              <PrimarySmall onClick={handleResultButton} className="w-full h-[62px]" text="See Recommended Products" />
            </div>
          )}

          <div className={style.buttonWrapper}>
            {question >= questions?.length ? (
              <PrimarySmall onClick={handleResultButton} className="w-full h-[62px]" text="See Recommended Products" />
            ) : (
              <PrimarySmall
                onClick={handleNextStepButton}
                className="w-full h-[62px]"
                text={`${isLoading ? 'Loading...' : 'Next'}`}
              />
            )}
          </div>
        </div>
      </FormProvider>
    </>
  );
};

export const getServerSideProps = createGetServerSidePropsFn(AddPet, async () => {
  const response = await getRequest(`/product_recomeendation`);
  const pets = response?.pets?.map((obj) => ({ ...obj, value: obj?.id }));
  const concerns = response?.concerns?.map((obj) => ({ ...obj, value: obj?.id, title: obj?.name }));

  return {
    props: {
      concerns: concerns || [],
      pets: pets || [],
    },
  };
});
AddPet.Layout = AuthLayout;
export default AddPet;
