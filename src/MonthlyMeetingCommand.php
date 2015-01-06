<?php
namespace Ucs;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MonthlyMeetingCommand extends Command
{
    protected function configure()
    {
        return $this->setName('show-monthly-meetings')
            ->setDescription("Shows the dates of Mid Month Meeting and End of Month Testing for the next 6 months in CSV format.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $tools = new DateTools;
        $date = new \DateTime;

        $reporter = new MonthlyMeetingReporter($tools, $date);

        // find the important meeting days of the next 6 months
        $result = $reporter->report();

        $csvData = [];
        $csvData[] = ['Month', 'Mid Month Meeting Date', 'End of Month Testing Date'];
        foreach ($result as $dates) {
            $midMonthMeetingDate = $dates[0];
            $endMonthMeetingDate = $dates[1];

            $monthName = $midMonthMeetingDate->format('F');

            $csvData[] = [
                $monthName,
                $midMonthMeetingDate->format('d'),
                $endMonthMeetingDate->format('d'),
            ];
        }

        $file = MY_PROJECT_ROOT . '/output.csv';
        $handle = fopen($file, 'w');

        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }

        $output->writeln('Successfully wrote output.csv');
    }
}
