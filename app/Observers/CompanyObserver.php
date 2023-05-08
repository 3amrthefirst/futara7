<?php

namespace App\Observers;

class CompanyObserver
{
    public function deleted(\App\Models\Company $company)
    {
        $company->product()->delete();
        $company->category()->delete();
    }
}
