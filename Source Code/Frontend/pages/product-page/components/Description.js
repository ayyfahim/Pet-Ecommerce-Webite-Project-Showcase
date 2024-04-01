import { useState } from 'react';
import styles from '../../../styles/product/Description.module.css'
import { BiChevronDown, BiChevronUp } from "react-icons/bi"
const spec_texts = [
  { type: "Lifestage", text: "All Lifestages"},
  { type: "Primary Flavor", text: "Seafood"},
  { type: "Brand", text: "Canopy animal health"},
  { type: "Target Species", text: "Dog" },
  { type: "Breed Recommendation", text: "All Breed Sizes"},
  { type: "Specific Uses For Product", text: "Calm" },
];
const nut_texts = [
  { type: 'Protein', text: '26.0' },
  { type: 'Fat content', text: '17.8' },
  { type: 'Crude ash', text: '12.5' },
  { type: 'Crude fibres', text: '15.6' },
  { type: 'Total Carbohydrate 13g', text: '6.6' },
  { type: 'Dietary Fibre 3g', text: '' },
  { type: 'Sugars 3g', text: '' },
  { type: 'Sodium 300mg', text: '' },
]
const direct_texts = [
  { type: '1~9', text: '275' },
  { type: '10~24', text: '226' },
  { type: '25~39', text: '363' },
  { type: '40+', text: '236' },
]

export default function Description() {
  const [ state, setState] = useState("Description");
  const description = () => {
    if(state == "Description") {
      setState("dec_none");
    } else setState("Description")
  }
  const Ingredients = () => {
    if(state == "Ingredients") {
      setState("ing_none")
    } else setState("Ingredients")
  }
  const Direction = () => {
    if(state == "Direction") {
      setState("dir_none")
    } else setState("Direction")
  }


  return (
    <>
      <div className={styles.description_field}>
        <div className={`${styles.dec_titleField} ${styles.width30}`}>
          <div onClick={ () => setState("Description")} className={`${styles.flexCol} ${styles.pointer}`}>
            <div className={ state =="Description" ? `${styles.mediumFont} ${styles.active_color}` : styles.mediumFont }>Description</div>
            <div className={ state == "Description" ? styles.active_mediumBorder : ''}></div>
          </div>
          <div onClick={ () => setState("Ingredients") } className={ state =="Ingredients" ? `${styles.mediumFont} ${styles.active_color} ${styles.pointer}` : `${styles.mediumFont} ${styles.pointer}` }>
            Ingredients
            <div className={ state == "Ingredients" ? styles.active_mediumBorder : ''}></div>
            </div>
          <div onClick={ () => setState("Direction") } className={ state =="Direction" ? `${styles.mediumFont} ${styles.active_color} ${styles.pointer}` : `${styles.mediumFont} ${styles.pointer}` }>
            Direction
            <div className={ state == "Direction" ? styles.active_mediumBorder : ''}></div>
          </div>
        </div>
        <div className={styles.border}></div>
        <div onClick={ () => setState("Description") } className={styles.description_title}>
          Description
        </div>
        <div onClick={ () => setState("Ingredients") } className={styles.ingredients_title}>
          Ingredients
        </div>
        <div onClick={ () => setState("Direction") } className={styles.direction_title}>
          Direction
        </div>  
        { state == "Description" ? 
          <div className={styles.dec_body}>
            <div className={styles.description}>
              <div className={styles.dec_title}>Description</div>   
              <div className={styles.dec_text}>
                26 mg of CBD from broad-spectrum hemp extract per soft chew.<br /><br/>
                780 mg of CBD per pouch. <br/><br />
                Tailored CBD for your dog with the gourmet flavors of fresh chicken and real cranberries in a unique soft baked chew designed by Martha herself. A perfect recipe combining only the highest-quality CBD from broad-spectrum hemp extract and chamomile to help dogs cope with everyday stress.<br /> <br />
                All of our ingredients are naturally derived and responsibly sourced with no artificial flavors, colors, or preservatives.<br /><br />
                Our CBD Pet Oil is formulated with your furry friends in mind, using organic ingredients and our premium human grade CBD. Our pet oil is crafted with Organic MCT Oil and natural beef and chicken flavorings. Each bottle comes equipped with a dropper applicator, allowing for flexible serving sizes allowing you to easily deliver an exact amount of CBD tincture to your pet&apos;s mouth or food.<br /><br />
                Available in flavor choices to please even the pickiest pets. Each of the three flavors also come in three different strengths to fit all sizes and temperaments.
              </div>
            </div>
            <div className={styles.specifications}>
              <div className={styles.dec_title}>Specifications</div>
              <div className={styles.specifications_field}>
                <div className={styles.flexCol}>
                  { spec_texts.map( (spec_text) => (
                    <div className={styles.spec_text_item} key={spec_text.text}>
                      <div className={styles.dec_type}>{spec_text.type}</div>
                      <div className={`${styles.dec_text} ${styles.fontBold}`}>{spec_text.text}</div>
                    </div>
                  ))}
                </div>
                <div className={styles.spec_border}></div>
                <div className={styles.spec_bottom}>
                  Please note that the product information displayed is provided by manufacturers, suppliers and other third parties and is not independently verified by VitalPawz.
                </div>
              </div>
            </div>
          </div>
        : state == "Ingredients" ?
          <div className={styles.dec_body2}>
            <div className={styles.description}>
              <div className={styles.dec_title}>Ingredients</div>
              <div className={styles.dec_text}>
                26 mg of CBD from broad-spectrum hemp extract per soft chew.<br /><br />
                780 mg of CBD per pouch.<br /><br />
                Tailored CBD for your dog with the gourmet flavors of fresh chicken and real cranberries in a unique soft baked chew designed by Martha herself. A perfect recipe combining only the highest-quality CBD from broad-spectrum hemp extract and chamomile to help dogs cope with everyday stress.<br /><br />
                All of our ingredients are naturally derived and responsibly sourced with no artificial flavors, colors, or preservatives.
              </div>
              <div className={styles.small_title}>
                Active Ingredients
              </div>
              <div className={styles.small_text}>
                GlycOmega Plus Perna canaliculus (Green-lipped mussel) 500mg per chew
              </div>
              <div className={styles.small_title}>
                Composition
              </div>
              <div className={styles.small_text}>
                <ul className={styles.ul}>
                  <li>chamomile</li>
                  <li>Beet Plup</li>
                  <li>Chicken</li>
                  <li>Cranberries</li>
                  <li>GlycOmega</li>
                  <li>Essential Fatty Acids: Omega 3 & 6, DHA, ETAs & EPA</li>
                  <li>Vitamins & Minerals:Iron, Calcium, Copper, Xinc, Lodine, Potassium, Vitamins B12 & Vitamin A</li>
                </ul>
              </div>
              <div className={styles.small_title}>
                All Ingredients<sapn className={styles.small_text}>: Chamomile, CBD from Broad Spectrum Hemp Extract Inactive Ingredients: Beet Pulp, Chicken, Chicken Meal, Cranberries, Glycerin, Mixed Tocopherols, Molasses, Natural Cranberry Flavor, Peas, Potato Flakes, Potato Starch, Poultry Fat, Rosemary Extract</sapn>
              </div>
              <div className={styles.small_title}>
                Analysis: Crude Protein Not less than 12.00%, Crude Fat Not less than 7.00%, Crude Fibre Not more than 5.50%, Moisture Not more than 11.00%. This product contains 3,406 kcal/kg or 136 kcal/piece ME (metabolizable energy) on an as fed basis.
              </div>
            </div>
            <div className={styles.specifications}>
              <div className={styles.dec_title}>Nutrition Facts</div>
              <div className={styles.specifications_field}>
                <div className={styles.flexCol}>
                  <div className={styles.spec_text}>Serving Size 1/2 cup(114g)</div>
                  <div className={`${styles.nut_filed_item} ${styles.small_title}`}>
                    <div>Amount Per Serving</div>
                    <div>% Daily Value</div>
                  </div>
                  <div className={styles.spec_border1}></div>
                  { nut_texts.map( (nut_text) => (
                    <div className={styles.nut_filed_item} key={nut_text.text}>
                      <div className={styles.dec_type}>{nut_text.type}</div>
                      <div className={`${styles.dec_text} ${styles.fontBold}`}>{nut_text.text}%</div>
                    </div>
                  ))}
                </div>
                <div className={styles.spec_border1}></div>
                <div className={`${styles.nut_filed_item} ${styles.small_title}`}>Weight Per kg</div>
                <div className={styles.nut_filed_item}>
                  <div className={styles.dec_type}>Omega 3 fatty acids</div>
                  <div className={`${styles.dec_text} ${styles.fontBold}`}>8.7g</div>
                </div>
                <div className={styles.nut_filed_item}>
                  <div className={styles.dec_type}>EPA/DHA</div>
                  <div className={`${styles.dec_text} ${styles.fontBold}`}>4g</div>
                </div>
                <div className={styles.spec_border}></div>
                <div className={styles.spec_bottom}>
                Percent Daily Values are based on a 2,000 calorie diet. Your daily value may be higher or lower depending on your calorie needs. The % Daily Value (DV) tells you how much a nutrient in a serving of food contributes to a daily diet.
                </div>
              </div>
            </div>
          </div>
        :
          <div className={styles.dec_body}>
            <div className={styles.description}>
              <div className={styles.dec_title}>Directions for use</div>
              <div className={styles.dec_text}>
                Follow recommended daily dose or as directed by veterinarian.<br /><br />
                Not recommended for use on an empty stomach. Used as directed based on your pet&apos;s weight. This product is intended for dogs and cats 12 weeks and older.<br /><br />
                Split your pets recommended usage amount between the morning and evening outside of mealtimes. Administer directly in mouth for max absorption. 
              </div>
              <div className={styles.small_title}>
                Easy to administer
              </div>
              <div className={styles.small_text}>
                To administer this pet CBD oil, you&apos;ll likely want to use the dropper provided to dispense into your dog&apos;s mouth directly. You&apos;ll also typically split your pet&apos;s recommended usage amount between morning and evening, outside of mealtimes. Shop for hemp oil for dogs and other dog health and wellness solutions online at Peptic. Natural Green Lipped mussel taste that dogs love. Inconvenient capsule format for consistent dosage.
              </div>
            </div>
            <div className={styles.specifications}>
              <div className={styles.dec_title}>Dose Guide</div>
              <div className={styles.spec_text}>Refer to packaging for complete feeding directions, first aid and disposal.</div>
              <div className={`${styles.nut_filed_item} ${styles.small_title}`}>
                    <div>Weight of Dog</div>
                    <div>Daily Does</div>
                  </div>
              <div className={styles.specifications_field}>
                <div className={styles.flexCol}>
                  { direct_texts.map( (direct_text) => (
                    <div className={styles.nut_filed_item} key={direct_text.text}>
                      <div className={styles.dec_type}>{direct_text.type}kg</div>
                      <div className={`${styles.dec_text} ${styles.fontBold}`}>{direct_text.text}g</div>
                    </div>
                  ))}
                </div>
              </div>
            </div>
          </div>
        }
      </div>
      
      <div className={styles.description_field2}>
        <div className={styles.border_top}></div>
        <div onClick={description} className={styles.dec_field}>
          <div className={styles.dec_title}>Description</div>
          { state == "Description" ? <BiChevronUp size={30} color="#525252" /> : <BiChevronDown size={30} color="#525252" /> }
        </div>
        { state == "Description" ? 
          <div className={styles.dec_body}>
            <div className={styles.description}> 
              <div className={styles.dec_text}>
                26 mg of CBD from broad-spectrum hemp extract per soft chew.<br /><br/>
                780 mg of CBD per pouch. <br/><br />
                Tailored CBD for your dog with the gourmet flavors of fresh chicken and real cranberries in a unique soft baked chew designed by Martha herself. A perfect recipe combining only the highest-quality CBD from broad-spectrum hemp extract and chamomile to help dogs cope with everyday stress.<br /> <br />
                All of our ingredients are naturally derived and responsibly sourced with no artificial flavors, colors, or preservatives.<br /><br />
                Our CBD Pet Oil is formulated with your furry friends in mind, using organic ingredients and our premium human grade CBD. Our pet oil is crafted with Organic MCT Oil and natural beef and chicken flavorings. Each bottle comes equipped with a dropper applicator, allowing for flexible serving sizes allowing you to easily deliver an exact amount of CBD tincture to your pet&apos;s mouth or food.<br /><br />
                Available in flavor choices to please even the pickiest pets. Each of the three flavors also come in three different strengths to fit all sizes and temperaments.
              </div>
            </div>
            <div className={styles.specifications}>
              <div className={styles.dec_title}>Specifications</div>
              <div className={styles.specifications_field}>
                <div className={styles.flexCol}>
                  { spec_texts.map( (spec_text) => (
                    <div className={styles.spec_text_item} key={spec_text.text}>
                      <div className={styles.dec_type}>{spec_text.type}</div>
                      <div className={`${styles.dec_text} ${styles.fontBold}`}>{spec_text.text}</div>
                    </div>
                  ))}
                </div>
                <div className={styles.spec_border}></div>
                <div className={styles.spec_bottom}>
                  Please note that the product information displayed is provided by manufacturers, suppliers and other third parties and is not independently verified by VitalPawz.
                </div>
              </div>
            </div>
          </div> 
        : "" }
        <div className={styles.border_top}></div>
        <div onClick={Ingredients} className={styles.ing_field}>
          <div className={styles.dec_title}>
            Ingredients
          </div>
          { state == "Ingredients" ? <BiChevronUp size={30} color="#525252" /> : <BiChevronDown size={30} color="#525252" /> }
        </div>
        { state == "Ingredients" ?
          <div className={styles.dec_body2}>
            <div className={styles.description}>
              <div className={styles.dec_text}>
                26 mg of CBD from broad-spectrum hemp extract per soft chew.<br /><br />
                780 mg of CBD per pouch.<br /><br />
                Tailored CBD for your dog with the gourmet flavors of fresh chicken and real cranberries in a unique soft baked chew designed by Martha herself. A perfect recipe combining only the highest-quality CBD from broad-spectrum hemp extract and chamomile to help dogs cope with everyday stress.<br /><br />
                All of our ingredients are naturally derived and responsibly sourced with no artificial flavors, colors, or preservatives.
              </div>
              <div className={styles.small_title}>
                Active Ingredients
              </div>
              <div className={styles.small_text}>
                GlycOmega Plus Perna canaliculus (Green-lipped mussel) 500mg per chew
              </div>
              <div className={styles.small_title}>
                Composition
              </div>
              <div className={styles.small_text}>
                <ul className={styles.ul}>
                  <li>chamomile</li>
                  <li>Beet Plup</li>
                  <li>Chicken</li>
                  <li>Cranberries</li>
                  <li>GlycOmega</li>
                  <li>Essential Fatty Acids: Omega 3 & 6, DHA, ETAs & EPA</li>
                  <li>Vitamins & Minerals:Iron, Calcium, Copper, Xinc, Lodine, Potassium, Vitamins B12 & Vitamin A</li>
                </ul>
              </div>
              <div className={styles.small_title}>
                All Ingredients<sapn className={styles.small_text}>: Chamomile, CBD from Broad Spectrum Hemp Extract Inactive Ingredients: Beet Pulp, Chicken, Chicken Meal, Cranberries, Glycerin, Mixed Tocopherols, Molasses, Natural Cranberry Flavor, Peas, Potato Flakes, Potato Starch, Poultry Fat, Rosemary Extract</sapn>
              </div>
              <div className={styles.small_title}>
                Analysis: Crude Protein Not less than 12.00%, Crude Fat Not less than 7.00%, Crude Fibre Not more than 5.50%, Moisture Not more than 11.00%. This product contains 3,406 kcal/kg or 136 kcal/piece ME (metabolizable energy) on an as fed basis.
              </div>
            </div>
            <div className={styles.specifications}>
              <div className={styles.dec_title}>Nuntrition Facts</div>
              <div className={styles.specifications_field}>
                <div className={styles.flexCol}>
                  <div className={styles.spec_text}>Serving Size 1/2 cup(114g)</div>
                  <div className={`${styles.nut_filed_item} ${styles.small_title}`}>
                    <div>Amount Per Serving</div>
                    <div>% Daily Value</div>
                  </div>
                  <div className={styles.spec_border1}></div>
                  { nut_texts.map( (nut_text) => (
                    <div className={styles.nut_filed_item} key={nut_text.text}>
                      <div className={styles.dec_type}>{nut_text.type}</div>
                      <div className={`${styles.dec_text} ${styles.fontBold}`}>{nut_text.text}%</div>
                    </div>
                  ))}
                </div>
                <div className={styles.spec_border1}></div>
                <div className={`${styles.nut_filed_item} ${styles.small_title}`}>Weight Per kg</div>
                <div className={styles.nut_filed_item}>
                  <div className={styles.dec_type}>Omega 3 fatty acids</div>
                  <div className={`${styles.dec_text} ${styles.fontBold}`}>8.7g</div>
                </div>
                <div className={styles.nut_filed_item}>
                  <div className={styles.dec_type}>EPA/DHA</div>
                  <div className={`${styles.dec_text} ${styles.fontBold}`}>4g</div>
                </div>
                <div className={styles.spec_border}></div>
                <div className={styles.spec_bottom}>
                Percent Daily Values are based on a 2,000 calorie diet. Your daily value may be higher or lower depending on your calorie needs. The % Daily Value (DV) tells you how much a nutrient in a serving of food contributes to a daily diet.
                </div>
              </div>
            </div>
          </div> 
        : "" }
        <div className={styles.border_top}></div>
        <div onClick={Direction} className={styles.dir_field}>
          <div className={styles.dec_title}>
            Direction
          </div>
          { state == "Direction" ? <BiChevronUp size={30} color="#525252" /> : <BiChevronDown size={30} color="#525252" /> }
        </div>
        { state == "Direction" ?
          <div className={styles.dec_body}>
            <div className={styles.description}>
              <div className={styles.dec_text}>
                Follow recommended daily dose or as directed by veterinarian.<br /><br />
                Not recommended for use on an empty stomach. Used as directed based on your pet&apos;s weight. This product is intended for dogs and cats 12 weeks and older.<br /><br />
                Split your pets recommended usage amount between the morning and evening outside of mealtimes. Administer directly in mouth for max absorption. 
              </div>
              <div className={styles.small_title}>
                Easy to administer
              </div>
              <div className={styles.small_text}>
                To administer this pet CBD oil, you&apos;ll likely want to use the dropper provided to dispense into your dog&apos;s mouth directly. You&apos;ll also typically split your pet&apos;s recommended usage amount between morning and evening, outside of mealtimes. Shop for hemp oil for dogs and other dog health and wellness solutions online at Peptic. Natural Green Lipped mussel taste that dogs love. Inconvenient capsule format for consistent dosage.
              </div>
            </div>
            <div className={styles.specifications}>
              <div className={styles.dec_title}>Dpse Guide</div>
              <div className={styles.spec_text}>Refer to packaging for complete feeding directions, first aid and disposal.</div>
              <div className={`${styles.nut_filed_item} ${styles.small_title}`}>
                    <div>Weight of Dog</div>
                    <div>Daily Does</div>
                  </div>
              <div className={styles.specifications_field}>
                <div className={styles.flexCol}>
                  { direct_texts.map( (direct_text) => (
                    <div className={styles.nut_filed_item} key={direct_text.text}>
                      <div className={styles.dec_type}>{direct_text.type}kg</div>
                      <div className={`${styles.dec_text} ${styles.fontBold}`}>{direct_text.text}g</div>
                    </div>
                  ))}
                </div>
              </div>
            </div>
          </div>
        : "" }
        { state == "Direction" ? "" : <div className={styles.border_top}></div>}
      </div>
    </>
  )
}