<?php
// src/ATrophy/Bundle/MeatBundle/Command/GarbageCollectorCommand.php
namespace ATrophy\Bundle\MeatBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Output\OutputInterface,
    Symfony\Component\Finder\Finder,
    Symfony\Component\Filesystem\Filesystem;

class GarbageCollectorCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('garbage:collect')
            ->setDescription('Greet someone')
            ->addArgument(
                'task',
                InputArgument::REQUIRED,
                'What task to execute?'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $task = $input->getArgument('task');

        switch( $task )
        {
            case 'pre_order':
                $this->deletePreOrderFiles();
            break;

            case 'post_order':

            break;

            default:
                return FALSE;
            break;
        }

        $output->writeln('Done!');
    }

    protected function deletePreOrderFiles()
    {
        $_finder     = new Finder;
        $_filesystem = new Filesystem;

        $directory = WEB_DIRECTORY . "/bundles/atrophymeat/images/tmp/pre_order";

        if( !file_exists($directory) ) {
            return FALSE;
        }

        $_finder->directories()->in($directory);

        $deathNote = [];

        foreach($_finder as $file)
        {
            $sessionTmpImagesRealpath = $file->getRealpath();
            $sessionTmpImagesPathname = $file->getRelativePathname();

            if( !$this->checkIfSessionActive($sessionTmpImagesPathname) )
                $deathNote[] = $sessionTmpImagesRealpath;
        }

        if( !empty($deathNote) ) {
            $_filesystem->remove($deathNote);
            $this->logDeletedPreOrderFiles($deathNote);
        }
    }

    protected function checkIfSessionActive($sessionId)
    {
        $_session = $this->getContainer()->get('session');

        $_session->setId($sessionId);

        $sessionData = $_session->all();

        $_session->save();

        return ( !empty($sessionData) ) ? TRUE : FALSE;
    }

    protected function logDeletedPreOrderFiles(array $folderNames)
    {
        if( empty($folderNames) ) {
            return FALSE;
        }

        $folderNames = implode(',', $folderNames);

        $_logger = $this->getContainer()->get('logger');
        $_logger->info("***YELL*** GarbageCollectorCommand killed {$folderNames}");
    }
}