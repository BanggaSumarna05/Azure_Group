<?php

namespace App\Http\Controllers;

use App\Mail\CareerApplicationMail;
use App\Models\Career;
use App\Models\CareerApplication;
use App\Services\RecaptchaService;
use App\Services\SeoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;

class CareerController extends Controller
{
    public function index(Request $request): Response
    {
        app(SeoService::class)->setPage(
            'Career',
            'Join Azure Group. Explore open positions and be part of building Indonesia\'s industrial future.'
        );

        $query = Career::open()->latest('published_at');

        if ($request->filled('type')) {
            $query->where('type', $request->query('type'));
        }

        return Inertia::render('Career/Index', [
            'careers'          => $query->get(['id', 'title', 'department', 'type', 'location', 'deadline']),
            'activeType'       => $request->query('type'),
            'recaptchaSiteKey' => config('services.recaptcha.site', ''),
        ]);
    }

    public function show(int $career): Response
    {
        $careerModel = Career::open()->findOrFail($career);

        app(SeoService::class)->setPage(
            $careerModel->title,
            'Apply for ' . $careerModel->title . ' at Azure Investama Group.'
        );

        return Inertia::render('Career/Show', [
            'career'           => $careerModel,
            'recaptchaSiteKey' => config('services.recaptcha.site', ''),
        ]);
    }

    // ── General application (not tied to a specific role) ─────────────────
    public function applyGeneral(Request $request): RedirectResponse
    {
        // reCAPTCHA v2 check
        if (! RecaptchaService::verify($request->input('recaptcha_token'))) {
            return back()->withErrors(['recaptcha_token' => 'Verifikasi keamanan gagal. Silakan coba lagi.']);
        }

        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'phone'   => ['required', 'string', 'max:30'],
            'message' => ['nullable', 'string', 'max:2000'],
            'cv'      => ['required', 'file', 'mimes:pdf', 'max:5120'],
        ]);

        // Store CV file
        try {
            $path = $request->file('cv')->store('career-applications/general', 'local');
        } catch (\Throwable $e) {
            return back()->withErrors(['cv' => 'Gagal mengunggah CV, coba lagi.']);
        }

        // Save to database
        $application = CareerApplication::create([
            'career_id' => null,
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'phone'     => $validated['phone'],
            'message'   => $validated['message'] ?? null,
            'cv_path'   => $path,
            'status'    => 'new',
        ]);

        // Send email notification
        try {
            Mail::to(config('mail.admin_address'))->send(
                new CareerApplicationMail(null, $validated, $path)
            );
        } catch (\Throwable $e) {
            Log::error('General career application email failed', [
                'application_id' => $application->id,
                'error'          => $e->getMessage(),
            ]);
        }

        return back()->with('success', 'Lamaran berhasil dikirim. Kami akan menghubungi Anda.');
    }

    // ── Application for a specific role ───────────────────────────────────
    public function apply(Request $request, Career $career): RedirectResponse
    {
        if (! $career->is_active || ! $career->published_at || $career->published_at->isFuture()) {
            abort(404);
        }

        // reCAPTCHA v2 check
        if (! RecaptchaService::verify($request->input('recaptcha_token'))) {
            return back()->withErrors(['recaptcha_token' => 'Verifikasi keamanan gagal. Silakan coba lagi.']);
        }

        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'phone'   => ['required', 'string', 'max:30'],
            'message' => ['nullable', 'string', 'max:2000'],
            'cv'      => ['required', 'file', 'mimes:pdf', 'max:5120'],
        ]);

        // Store CV file
        try {
            $path = $request->file('cv')->store('career-applications/' . $career->id, 'local');
        } catch (\Throwable $e) {
            return back()->withErrors(['cv' => 'Gagal mengunggah CV, coba lagi.']);
        }

        // Save to database
        $application = CareerApplication::create([
            'career_id' => $career->id,
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'phone'     => $validated['phone'],
            'message'   => $validated['message'] ?? null,
            'cv_path'   => $path,
            'status'    => 'new',
        ]);

        // Send email notification
        try {
            Mail::to(config('mail.admin_address'))->send(
                new CareerApplicationMail($career, $validated, $path)
            );
        } catch (\Throwable $e) {
            Log::error('Career application email failed', [
                'career_id'      => $career->id,
                'application_id' => $application->id,
                'error'          => $e->getMessage(),
            ]);
        }

        return back()->with('success', 'Lamaran berhasil dikirim. Kami akan menghubungi Anda.');
    }
}
