<?php

use App\Http\Controllers\AdminController\BrandController;
use App\Http\Controllers\AdminController\CategoryController;
use App\Http\Controllers\ClientController\CategoryController as ClientCategoryController;
use App\Http\Controllers\AdminController\DiscountController;
use App\Http\Controllers\AdminController\FeaturedCategoryController;
use App\Http\Controllers\AdminController\GalleryController;
use App\Http\Controllers\AdminController\OfferController;
use App\Http\Controllers\AdminController\PanelController;
use App\Http\Controllers\AdminController\ProductController;
use App\Http\Controllers\AdminController\ProductPropertyController;
use App\Http\Controllers\AdminController\PropertiesController;
use App\Http\Controllers\AdminController\PropertyController;
use App\Http\Controllers\AdminController\PropertyGroupController;
use App\Http\Controllers\AdminController\RoleController;
use App\Http\Controllers\AdminController\SliderController;
use App\Http\Controllers\AdminController\UserController;
use App\Http\Controllers\ClientController\CartController;
use App\Http\Controllers\ClientController\CommentController;
use App\Http\Controllers\AdminController\CommentController as AdminCommentController;
use App\Http\Controllers\ClientController\LikeController;
use App\Http\Controllers\ClientController\LoginController;
use App\Http\Controllers\ClientController\OrderController;
use App\Http\Controllers\ClientController\ProductController as ClientProductController;
use App\Http\Controllers\ClientController\indexController;
use App\Http\Controllers\ClientController\ProductSearchController;
use App\Http\Controllers\ClientController\ProfileController;
use App\Http\Controllers\ClientController\RegisterController;
use App\Http\Middleware\CheckPermission;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Client:
Route::prefix('')->name('client.')->group(function () {
    //Product:
    Route::get('/', [indexController::class, 'index'])->name('index');
    Route::get('productDetails/{product}', [ClientProductController::class, 'show'])->name('productDetails.show');
    Route::post('product/{product}/comments/store', [CommentController::class, 'store'])->name('product.comments.store');
    Route::get('/likes/wishList',[LikeController::class,'index'])->name('likes.wishList.index');
    Route::post('/likes/{product}',[LikeController::class,'store'])->name('likes.store');
    Route::delete('/likes/{product}',[LikeController::class,'destroy'])->name('likes.destroy');

    //Register:
    Route::get('register', [RegisterController::class, 'create'])->name('register');
    Route::post('register/sendmail', [RegisterController::class, 'sendMail'])->name('register.sendmail');
    Route::get('register/otp/{user}', [RegisterController::class, 'otp'])->name('register.otp');
    Route::post('register/verifyOtp/{user}', [RegisterController::class, 'verifyOtp'])->name('register.verifyOtp');
    Route::delete('logout', [RegisterController::class, 'logout'])->name('logout');
    Route::middleware('auth')->group(function(){
        Route::get('/changeUserPassword/edit', [RegisterController::class, 'changeUserPassword_edit'])->name('changeUserPassword.edit');
        Route::patch('/changeUserPassword/update', [RegisterController::class, 'changeUserPassword_update'])->name('changeUserPassword.update');
    });

    //login:
    Route::middleware('guest')->group(function(){
        Route::get('/login/create', [LoginController::class, 'create'])->name('login.create');
        Route::post('/login/store', [LoginController::class, 'store'])->name('login.store');
        Route::get('/login/google', [LoginController::class, 'redirectToProvider'])->name('login.google');
        Route::get('/login/google/callback', [LoginController::class, 'handleProviderCallback']);
    });

    //userProfile:
    Route::middleware('auth')->group(function(){
        Route::get('/myProfile',[ProfileController::class,'edit'])->name('myProfile.edit');
        Route::patch('/myProfile',[ProfileController::class,'update'])->name('myProfile.update');
        Route::get('/myProfile/changPassword/edit',[ProfileController::class,'changPassword_edit'])->name('myProfile.changPassword.edit');
        Route::patch('/myProfile/changPassword/update',[ProfileController::class,'changPassword_update'])->name('myProfile.changPassword.update');
    });

    //Cart:
    Route::get('/cart',[CartController::class,'index'])->name('cart.index');
    Route::post('/cart/{product}',[CartController::class,'store'])->name('cart.store');
    Route::delete('/cart/{product}',[CartController::class,'destroy'])->name('cart.destroy');

    //order:
    Route::get('/orders/create',[OrderController::class,'create'])->name('orders.create');
    Route::post('/orders/store',[OrderController::class,'store'])->name('orders.store');
    Route::get('/orders/payment/callback',[OrderController::class,'callback'])->name('orders.callback');
    Route::get('/orders/{order}',[OrderController::class,'show'])->name('orders.show');

    //category:
    Route::get('/category/{category}',[ClientCategoryController::class,'index'])->name('category.index');
    Route::get('/getChildCategory/{childCategory}',[ClientCategoryController::class,'getChildren'])->name('category.getChild');

    //productsSearch:
    Route::post('/product/search',[ProductSearchController::class,'fetchData']);

});

//************************************************************************************

//AdminPanel:

Route::prefix('adminPanel')->middleware([
//    CheckPermission::class . ':view-dashboard'
//    'auth'
])->group(function () {
    Route::resource('/', PanelController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('brand', BrandController::class);

    //products:
    Route::resource('product', ProductController::class);
    Route::resource('product.gallery', GalleryController::class);
    Route::resource('product.discount', DiscountController::class);
    Route::resource('offer', OfferController::class);
    Route::resource('slider', SliderController::class);
    Route::get('products/{product}/comments',[AdminCommentController::class,'index'])->name('products.comments.index');
    Route::get('comments/{comment}/edit',[AdminCommentController::class,'edit'])->name('products.comments.edit');
    Route::get('comments/{comment}/show',[AdminCommentController::class,'show'])->name('products.comments.show');
    Route::patch('comments/{comment}/update',[AdminCommentController::class,'update'])->name('products.comments.update');
    Route::delete('comments/{comment}/destroy',[AdminCommentController::class,'destroy'])->name('products.comments.destroy');
   //productProperty:
    Route::get('products/{product}/properties',[ProductPropertyController::class,'index'])->name('product.properties.index');
    Route::get('products/{product}/properties/create',[ProductPropertyController::class,'create'])->name('product.properties.create');
    Route::post('products/{product}/properties',[ProductPropertyController::class,'store'])->name('product.properties.store');

    //propertyGroup_&_property:
    Route::resource('propertyGroup', PropertyGroupController::class);
    Route::resource('properties', PropertyController::class);

    Route::resource('role', RoleController::class);
    Route::resource('user', UserController::class);

    Route::get('/featuredCategory/create',[FeaturedCategoryController::class,'create'])->name('featuredCategory.create');
    Route::post('/featuredCategory/store',[FeaturedCategoryController::class,'store'])->name('featuredCategory.store');
});
