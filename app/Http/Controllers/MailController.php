<?php

namespace App\Http\Controllers;

use App\Mail\AportacionMail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function mail(Request $request)
    {
        return view('mail');
    }
    public function sendMail(Request $request)
    {
        try {
            if ($request->tipo) {

                if ($request->tipo == 1) {
                    $subject = 'El precio ha bajado';
                } else {
                    $subject = 'El precio ha subido';
                }

                $content = "El precio es : $" . $request->precio;
                $recipientEmail = "hugo.alex.huezo@gmail.com";
                $file = public_path('aportacion.pdf');

                // Enviar el correo
                Mail::to($recipientEmail)->send(new AportacionMail($subject, $content, $file));

                // Retornar una respuesta JSON indicando que el correo fue enviado exitosamente
                return response()->json([
                    'success' => true,
                    'message' => 'El correo ha sido enviado correctamente.'
                ]);

            } else {
                // Si no se envió el correo, retornar un error
                return response()->json([
                    'success' => false,
                    'message' => 'El correo no ha sido enviado.'
                ]);
            }
        } catch (Exception $e) {
            // Si hay un error, retornar el error con el mensaje
            return response()->json([
                'success' => false,
                'message' => 'El correo no ha sido enviado correctamente.',
                'error' => $e->getMessage()
            ]);
        }

    }
}
