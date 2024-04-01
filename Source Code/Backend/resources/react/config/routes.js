// Importing layout component.
import IndexLayout from "../views/layouts/IndexLayout";
import AuthLayout from "../views/layouts/AuthLayout";
import DashboardLayout from "../views/layouts/DashboardLayout";
// Importing pages component.
import IndexPage from "../views/pages/IndexPage";
import PastDealsPage from "../views/pages/PastDealsPage";
import ProductListing from "../views/pages/ProductListing";
import ProductSingle from "../views/pages/ProductSingle";
import CategoryListing from "../views/pages/CategoryListing";
import CategorySingle from "../views/pages/CategorySingle";
import LoginPage from "../views/pages/auth/LoginPage";
import RegisterPage from "../views/pages/auth/RegisterPage";
import VerifyEmailPage from "../views/pages/auth/VerifyEmailPage";
import ForgotPasswordPage from "../views/pages/auth/ForgotPasswordPage";
import ResetPasswordPage from "../views/pages/auth/ResetPasswordPage";
import DashboardMyAccountPage from "../views/pages/dashboard/DashboardMyAccountPage";
import DashboardEditMyAccountPage from "../views/pages/dashboard/DashboardEditMyAccountPage";
import WishListPage from "../views/pages/WishListPage";
import CartPage from "../views/pages/CartPage";
import ShippingPage from "../views/pages/ShippingPage";
import PaymentPage from "../views/pages/PaymentPage";
import ContactUsPage from "../views/pages/ContactUsPage";
import StaticPage from "../views/pages/StaticPage";
import Redirect from "../views/pages/payment/Redirect";
import TermsAndConditionsPage from "../views/pages/TermsAndConditionsPage";
import FAQsPage from "../views/pages/FAQsPage";
import AboutPage from "../views/pages/AboutPage";
import OrderConfirmationPage from "../views/pages/OrderConfirmationPage";
import TrackOrdersPage from "../views/pages/TrackOrdersPage";
import DashboardOrderSummary from "../views/pages/dashboard/DashboardOrderSummary";
// Defining routes array.
const routes = [
    {
        layoutPath: "/",
        layout: IndexLayout,
        isExact: true,
        redirectTo: "/",
        routes: [
            {
                routePath: "/",
                component: IndexPage,
                pageTitle: "Home Page",
                isExact: true,
                isProtected: false
            }
        ]
    },
    {
        layoutPath: "/products",
        layout: IndexLayout,
        isExact: false,
        redirectTo: "/",
        routes: [
            {
                routePath: "/",
                component: ProductListing,
                pageTitle: "Products",
                isExact: true,
                isProtected: false
            },
            {
                routePath: "/:slug",
                component: ProductSingle,
                pageTitle: "Products",
                isExact: true,
                isProtected: false
            }
        ]
    },
    {
        layoutPath: "/category",
        layout: IndexLayout,
        isExact: false,
        redirectTo: "/",
        routes: [
            // {
            //     routePath: "/",
            //     component: CategoryListing,
            //     pageTitle: "categories",
            //     isExact: true,
            //     isProtected: false
            // },
            {
                routePath: "/:slug",
                component: CategorySingle,
                pageTitle: "categories",
                isExact: true,
                isProtected: false
            }
        ]
    },
    {
        layoutPath: "/login",
        layout: AuthLayout,
        isExact: false,
        redirectTo: "/login",
        routes: [
            {
                routePath: "/",
                component: LoginPage,
                pageTitle: "Login",
                isExact: true,
                isProtected: true
            }
        ]
    },
    {
        layoutPath: "/register",
        layout: AuthLayout,
        isExact: false,
        redirectTo: "/login",
        routes: [
            {
                routePath: "/",
                component: RegisterPage,
                pageTitle: "register",
                isExact: true,
                isProtected: true
            }
        ]
    },
    {
        layoutPath: "/password",
        layout: AuthLayout,
        isExact: false,
        redirectTo: "/login",
        routes: [
            {
                routePath: "/forgot",
                component: ForgotPasswordPage,
                pageTitle: "forgot password",
                isExact: true,
                isProtected: true
            },
            {
                routePath: "/reset/:token",
                component: ResetPasswordPage,
                pageTitle: "reset password",
                isExact: true,
                isProtected: true
            }
        ]
    },
    // {
    //     layoutPath: "/email",
    //     layout: DashboardLayout,
    //     isExact: false,
    //     redirectTo: "/dashboard/account",
    //     routes: [
    //         {
    //             routePath: "/verify",
    //             component: VerifyEmailPage,
    //             pageTitle: "Verify Email Address",
    //             isExact: true,
    //             isProtected: true
    //         },
    //         {
    //             routePath: "/verify/:token",
    //             component: VerifyEmailPage,
    //             pageTitle: "Verify Email Address",
    //             isExact: true,
    //             isProtected: true
    //         }
    //     ]
    // },
    {
        layoutPath: "/lists",
        layout: DashboardLayout,
        isExact: false,
        redirectTo: "/",
        routes: [
            {
                routePath: "/wishlist",
                component: WishListPage,
                pageTitle: "My Wishlist",
                isExact: true,
                isProtected: true
            }
        ]
    },
    {
        layoutPath: "/paymentCallback",
        layout: DashboardLayout,
        isExact: false,
        routes: [
            {
                routePath: "/redirect",
                component: Redirect,
                pageTitle: "payment redirect handler",
                isExact: true,
                isProtected: false
            }
        ]
    },
    {
        layoutPath: "/deals",
        layout: DashboardLayout,
        isExact: false,
        redirectTo: "/",
        routes: [
            {
                routePath: "/past",
                component: PastDealsPage,
                pageTitle: "Past Deals",
                isExact: true,
                isProtected: false
            }
        ]
    },
    {
        layoutPath: "/cart",
        layout: IndexLayout,
        isExact: false,
        redirectTo: "/",
        routes: [
            {
                routePath: "/",
                component: CartPage,
                pageTitle: "cart",
                isExact: true,
                isProtected: false
            }
        ]
    },
    {
        layoutPath: "/shipping",
        layout: DashboardLayout,
        isExact: false,
        redirectTo: "/",
        routes: [
            {
                routePath: "/",
                component: ShippingPage,
                pageTitle: "shipping",
                isExact: true,
                isProtected: false
            }
        ]
    },
    {
        layoutPath: "/payment",
        layout: DashboardLayout,
        isExact: false,
        redirectTo: "/",
        routes: [
            {
                routePath: "/",
                component: PaymentPage,
                pageTitle: "payment",
                isExact: true,
                isProtected: false
            }
        ]
    },
    {
        layoutPath: "/orders",
        layout: IndexLayout,
        isExact: false,
        redirectTo: "/",
        routes: [
            {
                routePath: "/track",
                component: TrackOrdersPage,
                pageTitle: "track you order",
                isExact: true,
                isProtected: false
            },
            {
                routePath: "/confirmation",
                component: OrderConfirmationPage,
                pageTitle: "order confirmation",
                isExact: true,
                isProtected: false
            }
        ]
    },
    {
        layoutPath: "/page",
        layout: IndexLayout,
        isExact: false,
        redirectTo: "/",
        routes: [
            {
                routePath: "/terms-and-conditions",
                component: TermsAndConditionsPage,
                pageTitle: "Terms & Conditions",
                isExact: true,
                isProtected: false
            },
            {
                routePath: "/faqs",
                component: FAQsPage,
                pageTitle: "frequently asked questions",
                isExact: true,
                isProtected: false
            },
            {
                routePath: "/about",
                component: AboutPage,
                pageTitle: "About",
                isExact: true,
                isProtected: false
            },
            {
                routePath: "/contact-us",
                component: ContactUsPage,
                pageTitle: "Contact us",
                isExact: true,
                isProtected: false
            }
            // {
            //     routePath: "/:slug",
            //     component: StaticPage,
            //     isExact: true,
            //     isProtected: false
            // }
        ]
    },
    {
        layoutPath: "/dashboard",
        layout: DashboardLayout,
        isExact: false,
        redirectTo: "/dashboard/account",
        routes: [
            {
                routePath: "/account",
                component: DashboardMyAccountPage,
                pageTitle: "My account",
                isExact: true,
                isProtected: true
            },
            {
                routePath: "/account/address/edit/:addressId",
                component: DashboardMyAccountPage,
                pageTitle: "My account",
                isExact: true,
                isProtected: true
            },
            {
                routePath: "/account/edit",
                component: DashboardEditMyAccountPage,
                pageTitle: "My account",
                isExact: true,
                isProtected: true
            },
            {
                routePath: "/orders",
                component: DashboardOrderSummary,
                pageTitle: "My account",
                isExact: true,
                isProtected: true
            }
        ]
    }
];

export default routes;
