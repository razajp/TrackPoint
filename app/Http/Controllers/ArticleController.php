<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Invoice;
use App\Models\Setups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Fetch filter parameters from the request
        $searchQuery = $request->input('search');
        $seasonId = $request->input('season', 'all');
        $sizeId = $request->input('size', 'all');
        $categoryId = $request->input('category', 'all');

        // Fetch the setup data
        $seasons = Setups::where('type', 'pcs_season')->get();
        $sizes = Setups::where('type', 'pcs_size')->get();
        $categories = Setups::where('type', 'pcs_category')->get();

        // Start querying articles
        $articles = Article::query();

        // Apply filters based on the input parameters
        if ($searchQuery) {
            $articles->where('article_no', 'like', "%$searchQuery%");
        }

        if ($seasonId !== 'all') {
            $articles->where('season_id', $seasonId);
        }

        if ($sizeId !== 'all') {
            $articles->where('size_id', $sizeId);
        }

        if ($categoryId !== 'all') {
            $articles->where('category_id', $categoryId);
        }

        // Execute the query and get the filtered articles
        $articles = $articles->get();

        foreach ($articles as $article) {
            $article["category"] = $article->category;
            $article["season"] = $article->season;
            $article["size"] = $article->size;
            $article["rates_array"] = json_decode($article->rates_array, true);
            $article['date'] = date('d-M-Y, D', strtotime($article['date']));
            $article['sales_rate'] = number_format($article['sales_rate'], 2, '.', ',');
        }

        // Return the view with the filtered articles
        // If it's an AJAX request, return just the updated content
        if ($request->ajax()) {
            return view('article.index', compact('articles', 'seasons', 'sizes', 'categories'));
        }

        // Otherwise, return the full page with the filtered content
        return view('article.index', compact('articles', 'seasons', 'sizes', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $types = Setups::all();

        $lastRecord = Article::orderBy('id', 'desc')->first();

        if ($lastRecord) {
            $lastRecord->rates_array = json_decode($lastRecord->rates_array, true);
            $lastRecord->total_rate = 0;
        } else {
            $lastRecord = '';
        }        

        $articles = Article::all();
        // return $lastRecord;
        return view('article.add-article', compact('types', 'lastRecord', 'articles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'article_no' => 'required|integer|unique:articles,article_no',
            'date' => 'required|date',
            'category_id' => 'required|exists:setups,id',
            'size_id' => 'required|exists:setups,id',
            'season_id' => 'required|exists:setups,id',
            'quantity' => 'required|integer|min:1',
            'extra_pcs' => 'required|integer|min:0',
            'fabric_type' => 'required|string',
            "sales_rate" => 'required|numeric|min:0',
            'image_upload' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Prepare data for saving
        $data = $request->all();

        // Handle the image upload if present
        if ($request->hasFile('image_upload')) {
            $file = $request->file('image_upload');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/images', $fileName, 'public'); // Store in public disk

            $data['image'] = $fileName; // Save the file path in the database
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Article::create($data);
        return redirect()->route('article.create')->with('success', 'Article added successfully');

        // return $request;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function articleTrack(Request $request)
    {
        $article_id = $request->articleId;
        if ($article_id) {
            $article = Article::with('category', 'season', 'size')->find($article_id);
            $invoices = Invoice::all();
            
            foreach ($invoices as $invoice) {
                $invoice['articles_array'] = json_decode($invoice['articles_array'], true);
            }

            $filteredInvoices = [];

            foreach ($invoices as $invoice) {
                foreach ($invoice['articles_array'] as $article_in_invoice) {
                    if ($article_in_invoice['articleNo'] == $article->article_no) {
                        $invoice['articles_array'] = $article_in_invoice;
                        $invoice['article'] = $article;
                        $ratesArray = json_decode($invoice['article']->rates_array , true);
                        $rate = 0;
                        foreach ($ratesArray as $rates){
                            $rate += $rates['rate'];
                        }
                        $invoice['rate'] = $rate;
                        $filteredInvoices[] = $invoice;
                        break;
                    }
                }
            }

            foreach ($filteredInvoices as $invoice) {
                $invoice['date'] = date('d-M-Y, D', strtotime($invoice['date']));
            }

            $articles = Article::with('category', 'season', 'size')->get();
            return view('article.article-track', compact('articles', 'invoices', 'filteredInvoices'));
            return $filteredInvoices;
        } else {
            $articles = Article::with('category', 'season', 'size')->get();
            return view('article.article-track', compact('articles'));
        }
    }
    public function addImage(Request $request)
    {
        // Validate input first
        $validator = Validator::make($request->all(), [
            'article_id' => 'integer|required|exists:articles,id',
            'image_upload' => 'nullable|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Prepare data for saving
        $data = [];
    
        // Handle the image upload if present
        if ($request->hasFile('image_upload')) {
            $file = $request->file('image_upload');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/images', $fileName, 'public'); // Store in public disk
    
            $data['image'] = $fileName; // Save the file path in the database
        }
    
        // Update only if image is set
        if (!empty($data['image'])) {
            Article::where('id', $request->article_id)->update(['image' => $data['image']]);
            return redirect()->route('article.index')->with('success', 'Image added successfully');
        } else {
            return redirect()->back()->with('error', 'Please upload an image');
        }
    }
}
