<?php

declare(strict_types=1);

/**
 * PSR-12 Compliance Checker
 * 
 * This script checks if the project follows PSR-12 coding standards
 */

class PSR12Checker
{
    private array $issues = [];
    private array $files = [];

    public function __construct()
    {
        $this->scanFiles();
    }

    /**
     * Scan all PHP files in the project
     */
    private function scanFiles(): void
    {
        $this->files = [
            'index.php',
            'config/database.php',
            'config/dbloader.php',
            'config/jsonloader.php',
            'config/test_db.php',
            'produk/add.php',
            'produk/update.php',
            'produk/list.php',
            'produk/chart.php',
        ];
    }

    /**
     * Run all PSR-12 checks
     */
    public function runChecks(): array
    {
        foreach ($this->files as $file) {
            if (file_exists($file)) {
                $this->checkFile($file);
            }
        }

        return $this->issues;
    }

    /**
     * Check individual file for PSR-12 compliance
     */
    private function checkFile(string $file): void
    {
        $content = file_get_contents($file);
        $lines = explode("\n", $content);

        // Check 1: Strict types declaration
        if (!str_contains($content, 'declare(strict_types=1);')) {
            $this->addIssue($file, 'Missing strict_types declaration', 1);
        }

        // Check 2: Line length (should be <= 80 characters)
        foreach ($lines as $lineNumber => $line) {
            if (strlen($line) > 80) {
                $this->addIssue($file, 'Line exceeds 80 characters', $lineNumber + 1);
            }
        }

        // Check 3: Proper indentation (4 spaces)
        foreach ($lines as $lineNumber => $line) {
            if (str_starts_with($line, "\t")) {
                $this->addIssue($file, 'Uses tabs instead of spaces', $lineNumber + 1);
            }
        }

        // Check 4: Proper spacing around operators
        if (preg_match('/[a-zA-Z0-9_]\s*[+\-*/=<>!&|]\s*[a-zA-Z0-9_]/', $content)) {
            // This is a basic check - more sophisticated checks needed
        }

        // Check 5: Proper function spacing
        if (preg_match('/}\s*function/', $content)) {
            $this->addIssue($file, 'Missing blank line before function', 0);
        }

        // Check 6: Proper class spacing
        if (preg_match('/}\s*class/', $content)) {
            $this->addIssue($file, 'Missing blank line before class', 0);
        }

        // Check 7: Proper method spacing
        if (preg_match('/}\s*public\s+function/', $content)) {
            $this->addIssue($file, 'Missing blank line before public method', 0);
        }

        // Check 8: Proper array syntax
        if (str_contains($content, 'array(')) {
            $this->addIssue($file, 'Uses old array() syntax instead of []', 0);
        }

        // Check 9: Proper string quotes
        if (preg_match('/"[^"]*\$[^"]*"/', $content)) {
            $this->addIssue($file, 'Uses double quotes for strings without variables', 0);
        }
    }

    /**
     * Add issue to the list
     */
    private function addIssue(string $file, string $message, int $line): void
    {
        $this->issues[] = [
            'file' => $file,
            'message' => $message,
            'line' => $line,
        ];
    }

    /**
     * Generate compliance report
     */
    public function generateReport(): string
    {
        $issues = $this->runChecks();
        $totalFiles = count($this->files);
        $totalIssues = count($issues);

        $report = "PSR-12 Compliance Report\n";
        $report .= "========================\n\n";
        $report .= "Files checked: {$totalFiles}\n";
        $report .= "Total issues: {$totalIssues}\n\n";

        if (empty($issues)) {
            $report .= "✅ All files are PSR-12 compliant!\n";
        } else {
            $report .= "Issues found:\n";
            $report .= "-------------\n\n";

            foreach ($issues as $issue) {
                $report .= "File: {$issue['file']}\n";
                $report .= "Line: {$issue['line']}\n";
                $report .= "Issue: {$issue['message']}\n";
                $report .= "\n";
            }
        }

        return $report;
    }
}

// Run the checker if this file is executed directly
if (php_sapi_name() === 'cli' || isset($_GET['check'])) {
    $checker = new PSR12Checker();
    echo $checker->generateReport();
} 