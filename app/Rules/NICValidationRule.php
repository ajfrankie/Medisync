<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use DateTimeImmutable;

class NICValidationRule implements ValidationRule
{
    private $birthday;
    private $gender;

    /**
     * Constructor accepts birthday and gender for cross-validation.
     *
     * @param string|null $birthday
     * @param string|null $gender
     */
    public function __construct(?string $birthday, ?string $gender)
    {
        $this->birthday = $birthday;
        $this->gender = strtolower((string) $gender); // normalize
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Accept both old (9 digits + V/X) and new (12 digits) NIC formats
        $pattern = '/^\d{9}[VXvx]$|^\d{12}$/';

        if (!preg_match($pattern, $value)) {
            $fail("The $attribute must be a valid Sri Lankan NIC number.");
            return;
        }

        // Extract DOB and gender from NIC
        $birthDateFromNIC = $this->extractBirthDate($value);
        $genderFromNIC = $this->extractGender($value);

        // Check if birthdate matches provided date
        if ($birthDateFromNIC !== $this->birthday) {
            $fail("The $attribute does not match the provided date of birth.");
        }

        // Check if gender matches provided gender
        if ($genderFromNIC !== $this->gender) {
            $fail("The $attribute does not match the provided gender.");
        }
    }

    /**
     * Extract birthdate from NIC.
     */
    private function extractBirthDate(string $nic): ?string
    {
        if (strlen($nic) === 10) {
            // Old NIC: YYDDD + V/X
            $year = '19' . substr($nic, 0, 2);
            $dayOfYear = (int) substr($nic, 2, 3);
        } elseif (strlen($nic) === 12) {
            // New NIC: YYYYDDD
            $year = substr($nic, 0, 4);
            $dayOfYear = (int) substr($nic, 4, 3);
        } else {
            return null;
        }

        // Gender adjustment (female NICs have +500)
        if ($dayOfYear > 500) {
            $dayOfYear -= 500;
        }

        // Leap year adjustment
        if (!$this->isLeapYear((int) $year) && $dayOfYear > 59) {
            $dayOfYear -= 1;
        }

        // Convert day-of-year to date
        $date = DateTimeImmutable::createFromFormat('Y-z', "$year-" . ($dayOfYear - 1));

        return $date ? $date->format('Y-m-d') : null;
    }

    /**
     * Extract gender from NIC.
     */
    private function extractGender(string $nic): ?string
    {
        $dayOfYear = strlen($nic) === 10
            ? (int) substr($nic, 2, 3)
            : (int) substr($nic, 4, 3);

        return $dayOfYear > 500 ? 'female' : 'male';
    }

    /**
     * Check leap year.
     */
    private function isLeapYear(int $year): bool
    {
        return ($year % 4 === 0 && $year % 100 !== 0) || ($year % 400 === 0);
    }
}
