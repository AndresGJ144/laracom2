<?php 
 
namespace App\Http\Controllers\Front;

use App\Shop\Products\Product;
use App\Shop\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Shop\Products\Transformations\ProductTransformable;

use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use DB;

class ProductController extends Controller
{
    use ProductTransformable;

    /**
     * @var ProductRepositoryInterface
     * @var CategoryRepositoryInterface
     */
    private $productRepo;

    private $categoryRepo;

    /**
     * ProductController constructor.
     * @param ProductRepositoryInterface $productRepository
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository,CategoryRepositoryInterface $categoryRepository)
    {
        $this->productRepo = $productRepository;
        $this->categoryRepo = $categoryRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    /*public function search()
    {
        $list = $this->productRepo->searchProduct(request()->input('q'));

        $products = $list->map(function (Product $item) {
            return $this->transformProduct($item);
        })->all();

        return view('front.products.product-search', [
            'products' => $this->productRepo->paginateArrayResults($products, 10)
        ]);
    }*/

       public function search()
    {
        $list = $this->productRepo->listProducts();

        if (request()->has('q') && request()->input('q') != '' && request()->input('inputMinimo') != '' && request()->input('inputMaximo') != '') {
            //$list = $this->productRepo->searchProduct(request()->input('q'))->whereBetween('price', ['inputMinimo', 'inputMaximo']);

            $products = DB::table('products')
            ->where('name', 'like', '%'.request()->input('q').'%')
            ->whereBetween('price', [intval(request()->input('inputMinimo')), intval(request()->input('inputMaximo'))])->paginate(10);

            return view('front.products.product-search', [
                'products' => $products
            ]);
        }

        if (request()->has('q') && request()->input('q') != '' && request()->input('inputMinimo') == '' && request()->input('inputMaximo') == '') {
            $list = $this->productRepo->searchProduct(request()->input('q'));
            $products = $list->map(function (Product $item) {
                return $this->transformProduct($item);
            });

            return view('front.products.product-search', [
                'products' => $this->productRepo->paginateArrayResults($products->all(), 10)
            ]);
        }

        

        
    }
 
    /**
     * Get the product
     *
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $slug)
    {
        $product = $this->productRepo->findProductBySlug(['slug' => $slug]);
        $images = $product->images()->get();
        //El precio del producto podria variar en funcion de color / tamaño / peso entre otros atributos .. Entonces lo que se quiere es que el precio en la vista varie en funcion de sus atributos .. si los tiene.
        $productAttributes = $product->attributes()->get();
        
        $category2 = $this->categoryRepo->findCategoryById(2);
        $category3 = $this->categoryRepo->findCategoryById(3); 

        $newests = $category2->products;
        $features = $category3->products;
        
        // categories - selectedIds -- Estas variables son necesarias para mostrar el producto a que categoria pertenece ... basado sobre la funcion edit de app/Http/Controllers/Admin/Products/ProductController para la vista de admin/products/edit .. 

        //$varCategories = $this->categoryRepo->listCategories('name', 'asc')->where('parent_id', 1);
        //$selectedIds = $product->categories()->pluck('category_id')->all();

        return view('front.products.product', [
            'categories' => $this->categoryRepo->listCategories('name', 'asc')->where('parent_id', 1),
            'selectedIds' => $product->categories()->pluck('category_id')->all(),
            'productAttributes' => $productAttributes
        ],
            compact('product', 'images', 'newests', 'features', 'category2', 'category3')
        ); 

        /*
         compact('product', 'images', 'newests', 'features', 'category2', 'category3','categories','selectedIds','productAttributes')

            'categories' => $categories,
            'selectedIds' => $selectedIds,
            'productAttributes' => $productAttributes,
            'product' => $product,
            'images' => $images,
            'newests' => $newests,
            'features' => $features,
            'category2' => $category2,
            'catagory3' => $category3



        [
        'categories' => $this->categoryRepo->listCategories('name', 'asc')->where('parent_id', 1),
        'selectedIds' => $product->categories()->pluck('category_id')->all(),
        'productAttributes' => $productAttributes      
        */
    }
}
