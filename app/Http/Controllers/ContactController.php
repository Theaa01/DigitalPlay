<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Manejar el envío del formulario de contacto.
     */
    public function submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $email = $request->input('email');

        // Enviar correo al administrador
        Mail::to('admin@digitalplay.com')->send(new \App\Mail\ContactFormSubmitted($email));

        return back()->with('success', 'Gracias por tu contacto. Pronto nos pondremos en contacto contigo.');
    }
}
