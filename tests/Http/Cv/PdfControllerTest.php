<?php

declare(strict_types=1);

use App\Models\BasicEducationInfo;
use App\Models\Candidate;
use App\Models\ContactInfo;
use App\Models\Cv;
use App\Models\HigherEducation;
use App\Models\LanguageInfo;
use App\Models\PersonalInfo;
use App\Models\ResidenceInfo;
use App\Models\User;
use App\Models\WorkExperience;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\PdfBuilder;

test('response with a pdf', function () {
    Pdf::fake();

    $user = User::factory()
        ->for(Candidate::factory()
            ->has(Cv::factory(['user_id' => 1])
                ->completed()
                ->has(PersonalInfo::factory())
                ->has(ContactInfo::factory())
                ->has(ResidenceInfo::factory())
                ->has(BasicEducationInfo::factory())
                ->has(HigherEducation::factory(2))
                ->has(WorkExperience::factory(2))
                ->has(LanguageInfo::factory(2))
            ), 'userable')
        ->create();

    $response = $this->actingAs($user)->get('/cv/pdf');

    $response->assertOk();
    Pdf::assertRespondedWithPdf(function (PdfBuilder $pdf) {
        return $pdf->downloadName === 'hv.pdf';
    });
});
