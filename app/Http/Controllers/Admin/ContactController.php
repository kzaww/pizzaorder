<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ContactController extends Controller
{
    //insert data to contact table
    public function createContact(Request $request){
        $data = $this->requestUserData($request);
        Contact::create($data);
        return back()->with(['contactSuccess'=>'Message Send']);
    }

    //direct contact list
    public function contactList()
    {
        if(Session::has('contact_search')){
            Session::forget('contact_search');
        }
        $data = Contact::orderBy('contact_id','desc')->paginate(7);
        if(count($data)==0){
            $emptyStatus = 0;
        }else{
            $emptyStatus = 1;
        }
        return view('admin.contact.list')->with(['contact'=>$data,'status'=>$emptyStatus]);
    }

    //search contact
    public function contactSearch(Request $request)
    {
        $data = Contact::orwhere('name','like','%'.$request->searchData.'%')
                        ->orwhere('email','like','%'.$request->searchData.'%')
                        ->orwhere('message','like','%'.$request->searchData.'%')
                        ->paginate(7);

        $data->appends($request->all());

        Session::put('contact_search',$request->searchData);
        if(count($data)==0){
            $emptyStatus = 0;
        }else{
            $emptyStatus = 1;
        }
        return view('admin.contact.list')->with(['contact'=>$data,'status'=>$emptyStatus]);
    }


    public function contactDownload()
    {
        if(Session::has('contact_search')){
            $contact = Contact::orwhere('name','like','%'.Session::get('contact_search').'%')
                            ->orwhere('email','like','%'.Session::get('contact_search').'%')
                            ->orwhere('message','like','%'.Session::get('contact_search').'%')
                            ->get();
        }else{
            $contact = Contact::orderBy('contact_id','desc')->get();//GET DATA
        }

        $csvExporter = new \Laracsv\Export(); //BUILD OBJECT

        $csvExporter->build($contact, [
            'contact_id' => 'No',
            'name' => 'Name',
            'email' => 'Email',
            'message'=>'Message',
            'created_at' => 'Created date',
            'updated_at' => 'Updated date',
        ]);//FIRST '' IS TABLE FIELD(COLUMN) NAME SEC '' IS INSIDE DOWNLOAD FIELD(COLUMN) NAME

        $csvReader = $csvExporter->getReader(); //READER FOR CSV OBJECT

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8); // WHICH FONT USE IN READER

        $filename = 'contactList.csv'; // FILE NAME

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"'); //DOWNLOAD OR EXPROT FILE
    }
    //change array to insert in contact table
    private function requestUserData($request)
    {
        return [
            'user_id'=>Auth()->user()->id,
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ];
    }
}
