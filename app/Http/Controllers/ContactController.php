<?php

namespace App\Http\Controllers;

use App\Models\User\Contact;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request)
    {
        // Sử dụng validated() để lấy dữ liệu đã xác thực
        $validatedData = $request->validated();
        // dd($validatedData);

        // Lưu thông tin liên hệ vào cơ sở dữ liệu
        Contact::create($validatedData);

        // Thông báo thành công và chuyển hướng
        return redirect()->back()->with('success', 'Tin nhắn của bạn gửi thành công!! Chúng tôi sẽ đọc và phản hồi bạn sớm nhất.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        //
    }
}
