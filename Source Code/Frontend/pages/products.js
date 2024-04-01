import Navbar from '@/components/Navbar'
import Search from '@/components/Search'
import Footer from '@/components/Footer'
import HeaderPurple from '@/components/headers/HeaderPurple'
import ShopByConcern from '@/components/ShopByConcern'
import ProductsList from '@/components/products-listing/ProductsList'
import GenericHead from '@/components/GenericHead'

export default function Products() {
  return (
    <div>
      <GenericHead />
      <Navbar/>
      <Search/>
      <HeaderPurple heading="Vitamins & Supplements"
                    description="It is a good idea to provide a supplementary vitamin and mineral supplement, and definitely a probiotic to balance the nutrient depletion in the body"/>
      <ShopByConcern/>
      <ProductsList/>
      <Footer/>
    </div>
  )
}