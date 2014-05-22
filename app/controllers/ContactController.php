<?php

class ContactController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$contacts = Contact::all();
                
                // output the contacts
                return(Response::json(array(
                    "error" => false,
                    "contacts" => $contacts->toArray()),
                    200));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
	    //
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
            // validate the data
            $validator = Validator::make(array(
                "name" => Request::get("name"),
                "number" => Request::get("number"),
            ),
            array(
                "name" => "required|regex:/^[A-Za-z\s\-\']+$/",
                "number" => "regex:/^[(]?\d{3}[)]?[-\.\s]\d{3}[-\.]\d{4}$/",
                )
            );
            
            if($validator->fails())
            {
                return(Response::json(array(
                    "error" => true,
                    "message" => "contact not created"),
                    406));
            }
            
            $contact = new Contact();
            $contact->name = Request::get("name");
            $contact->number = Request::get("number");
            
            $contact->save();
            
            return(Response::json(array(
                "error" => false,
                "message" => "contact created",
                "id" => $contact->id),
                200));
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
	    $contact = Contact::where("id", $id)->take(1)->get();
            return(Response::json(array(
                "error" => false,
                "contact" => $contact->toArray()),
                200));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
	    $contact = Contact::where("id", $id)->find($id);
            if(Request::get("name"))
            {
                $contact->name = Request::get("name");
            }
            if(Request::get("number"))
            {
                $contact->number = Request::get("number");   
            }
            $contact->save();
            return(Response::json(array(
                "error" => false,
                "message" => "contact updated"),
                202));
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
            $contact = Contact::where("id", $id)->find($id);
            $contact->delete();
            return(Response::json(array(
                "error" => false,
                "message" => "contact deleted"),
                200));
	}


}
