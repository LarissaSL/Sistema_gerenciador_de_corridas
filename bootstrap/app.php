<?php

use App\Services\TelegramService;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // $exceptions->report(function (Throwable $e) {
        //     try {
        //         $telegramService = app(TelegramService::class);
        //         $message = "🚨 <b>Erro na Aplicação</b> 🚨\n\n"
        //                     . "<b>Mensagem</b> \n" . $e->getMessage() . "\n\n"
        //                     . "<b>Arquivo</b> \n" . $e->getFile() . "\n\n"
        //                     . "<b>Linha</b> \n" . $e->getLine();


        //         $telegramService->sendMessage($message);
        //     } catch (\Exception $ex) {
        //         dd('erro' . $ex->getMessage());
        //         error_log("Erro ao enviar exceção para o Telegram: " . $ex->getMessage());
        //     }
        // });
    })->create();
