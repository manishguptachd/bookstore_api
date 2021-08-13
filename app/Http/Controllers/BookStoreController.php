<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Publication;
use App\Models\Book;
use App\Models\Author;
use DB;

class BookStoreController extends Controller
{

    // to create new author and return name with api_token
    public function addAuthor(Request $request)
    {
        try 
        {
            $author_name = !empty($request->author_name) ? trim($request->author_name) : null;
            
            if(!empty($author_name))
            {
                $author_arr = [];
                $author_arr = [
                    'name' => $author_name,
                    'is_active' => 1,
                    'api_token' => Str::random(60),
                ];
                $create_author = Author::create($author_arr);

                $data = array('name' => $create_author->name, 'api_token' => $create_author->api_token);

                return response()->json(array('success' => true, 'msg' => 'Author created successfully.', 'data' => $data));
            }
            else
            {
                return response()->json(array('success' => false, 'msg' => 'Provide author name.'));
            }
        }
        catch (\Exception $e) 
        {
            return response()->json(array('success' => false, 'msg' => 'Error on line '.$e->getLine().' in '.$e->getFile().': <b>'.$e->getMessage()));
        }
    }

    // to create new publication and return name
    public function addPublication(Request $request)
    {
        try 
        {
            $publication_name = !empty($request->publication_name) ? trim($request->publication_name) : null;
            $api_token_exist = (!empty($request->api_token)) ? trim($request->api_token) : null;

            $token_auth = Author::where('api_token', $api_token_exist)->where('is_active', 1)->pluck('id');
            
            if(!empty($publication_name) && !empty($token_auth))
            {
                $publication_arr = [];
                $publication_arr = [
                    'name' => $publication_name,
                    'is_active' => 1,
                ];
                $create_publication = Publication::create($publication_arr);

                $data = array('id' => $create_publication->id, 'name' => $create_publication->name);

                return response()->json(array('success' => true, 'msg' => 'Publication added successfully.', 'data' => $data));
            }
            else
            {
                return response()->json(array('success' => false, 'msg' => 'Provide publication name.'));
            }
        }
        catch (\Exception $e) 
        {
            return response()->json(array('success' => false, 'msg' => 'Error on line '.$e->getLine().' in '.$e->getFile().': <b>'.$e->getMessage()));
        }
    }

    // to add new books and return name with api_token
    public function addBook(Request $request)
    {
        try 
        {
            $author_id = (!empty($request->author_id)) ? trim($request->author_id) : null;
            $book_name = (!empty($request->book_name)) ? trim($request->book_name) : null;
            $publication_id = (!empty($request->publication_id)) ? trim($request->publication_id) : null;
            $api_token_exist = (!empty($request->api_token)) ? trim($request->api_token) : null;

            $token_auth = Author::where('api_token', $api_token_exist)->where('is_active', 1)->pluck('id');
            
            if(isset($token_auth))
            {
                if(!empty($author_id) && !empty($book_name) && !empty($publication_id))
                {
                    $book_arr = array();
                    $book_arr = array(
                        'name' => $book_name,
                        'is_active' => 1,
                        'publication_id' => $publication_id,
                        'author_id' => $author_id
                    );
    
                    $create_book = Book::create($book_arr);

                    $data = array(
                        'id' => $create_author->id,
                        'book_name' => $create_author->name,
                        'publication_id' => $create_author->publication_id,
                        'author_id' => $create_author->author_id,
                        'is_active' => $create_author->is_active,
                    );
    
                    return response()->json(array('success' => true, 'msg' => 'Book added successfully.', 'data' => $create_book));
                }
            }
            else
            {
                return response()->json(array('success' => false, 'msg' => 'Unauthorised author.'));
            }
        }
        catch (\Exception $e) 
        {
            return response()->json(array('success' => false, 'msg' => 'Error on line '.$e->getLine().' in '.$e->getFile().': <b>'.$e->getMessage()));
        }
    }

    // update and delete for Author
    public function crudAuthor(Request $request)
    {
        try 
        {
            $crud = !empty($request->crud) ? trim($request->crud) : null;
            $author_id = !empty($request->author_id) ? trim($request->author_id) : null;
            $author_name = !empty($request->author_name) ? trim($request->author_name) : null;
            $api_token_exist = (!empty($request->api_token)) ? trim($request->api_token) : null;

            $token_auth = Author::where('api_token', $api_token_exist)->where('is_active', 1)->pluck('id');

            // update
            if($crud == 3 && !empty($author_name) && !empty($token_auth))
            {
                $update_existing_author = Author::where('id', $author_id)->where('is_active', 1)->update(['name' => $author_name]);

                return response()->json(array('success' => true, 'msg' => 'Author updated successfully.'));
            }
            else
            {
                return response()->json(array('success' => false, 'msg' => 'Please provide author name.'));
            }

            // delete
            if($crud == 4 && !empty($token_auth))
            {
                $update_existing_author = Author::where('api_token', $api_token_exist)->where('is_active', 1)->update(['is_active' => 0]);

                return response()->json(array('success' => true, 'msg' => 'Author deleted successfully.'));
            }
            else
            {
                return response()->json(array('success' => false, 'msg' => 'Please provide token id.'));
            }
        }
        catch (\Exception $e) 
        {
            return response()->json(array('success' => false, 'msg' => 'Error on line '.$e->getLine().' in '.$e->getFile().': <b>'.$e->getMessage()));
        }
    }

    // update and delete for Publication
    public function crudPublication(Request $request)
    {
        try 
        {
            $crud = !empty($request->crud) ? trim($request->crud) : null;
            $publication_id = !empty($request->publication_id) ? trim($request->publication_id) : null;
            $publication_name = !empty($request->publication_name) ? trim($request->publication_name) : null;
            $api_token_exist = (!empty($request->api_token)) ? trim($request->api_token) : null;

            $token_auth = Author::where('api_token', $api_token_exist)->where('is_active', 1)->pluck('id');

            // update
            if($crud == 3 && !empty($publication_name) && !empty($token_auth))
            {
                $update_pulication_name = Publication::where('id', $publication_id)->where('is_active', 1)->update(['name' => $publication_name]);

                return response()->json(array('success' => true, 'msg' => 'Publication name updated successfully.'));
            }
            else
            {
                return response()->json(array('success' => false, 'msg' => 'Please provide publication name.'));
            }

            // delete
            if($crud == 4 && !empty($token_auth))
            {
                $delete_publication = Publication::where('id', $publication_id)->where('is_active', 1)->update(['is_active' => 0]);

                return response()->json(array('success' => true, 'msg' => 'Publication deleted successfully.'));
            }
            else
            {
                return response()->json(array('success' => false, 'msg' => 'Please provide token id.'));
            }
        }
        catch (\Exception $e) 
        {
            return response()->json(array('success' => false, 'msg' => 'Error on line '.$e->getLine().' in '.$e->getFile().': <b>'.$e->getMessage()));
        }
    }

    // update and delete for Books
    public function crudBooks(Request $request)
    {
        try 
        {
            $crud = !empty($request->crud) ? trim($request->crud) : null;
            $book_id = !empty($request->book_id) ? trim($request->book_id) : null;
            $book_name = !empty($request->book_name) ? trim($request->book_name) : null;
            $api_token_exist = (!empty($request->api_token)) ? trim($request->api_token) : null;

            $token_auth = Author::where('api_token', $api_token_exist)->where('is_active', 1)->pluck('id');

            // update
            if($crud == 3 && !empty($book_name) && !empty($token_auth))
            {
                $update_book_name = Book::where('id', $book_id)->where('is_active', 1)->update(['name' => $book_name]);

                return response()->json(array('success' => true, 'msg' => 'Book name updated successfully.'));
            }
            else
            {
                return response()->json(array('success' => false, 'msg' => 'Please provide book name.'));
            }

            // delete
            if($crud == 4 && !empty($token_auth))
            {
                $delete_book = Book::where('id', $book_id)->where('is_active', 1)->update(['is_active' => 0]);

                return response()->json(array('success' => true, 'msg' => 'Book deleted successfully.'));
            }
            else
            {
                return response()->json(array('success' => false, 'msg' => 'Please provide token id.'));
            }
        }
        catch (\Exception $e) 
        {
            return response()->json(array('success' => false, 'msg' => 'Error on line '.$e->getLine().' in '.$e->getFile().': <b>'.$e->getMessage()));
        }
    }

    // to view author by token id
    public function viewAuthor(Request $request)
    {
        try
        {
            $api_token_exist = (!empty($request->api_token)) ? trim($request->api_token) : null;

            $token_auth = Author::where('api_token', $api_token_exist)->where('is_active', 1)->pluck('id');

            if(!empty($token_auth))
            {
                return $token_auth = Author::where('api_token', $api_token_exist)->where('is_active', 1)->get();
            }
        }
        catch (\Exception $e) 
        {
            return response()->json(array('success' => false, 'msg' => 'Error on line '.$e->getLine().' in '.$e->getFile().': <b>'.$e->getMessage()));
        }
    }

    // to view Books with author and publication
    public function viewBook(Request $request)
    {
        try
        {
            $api_token_exist = (!empty($request->api_token)) ? trim($request->api_token) : null;

            $token_auth = Author::where('api_token', $api_token_exist)->where('is_active', 1)->pluck('id');

            if(!empty($token_auth))
            {
                return DB::select("SELECT b.id as id, b.name as book_name, a.name as auther_name, p.name as publication_name, a.api_token as api_token
                FROM books b
                JOIN authors a ON a.id = b.author_id
                JOIN publications p ON p.id = b.publication_id
                WHERE a.api_token = '$api_token_exist'");

            }
        }
        catch (\Exception $e) 
        {
            return response()->json(array('success' => false, 'msg' => 'Error on line '.$e->getLine().' in '.$e->getFile().': <b>'.$e->getMessage()));
        }
    }
}
