<?php

declare(ticks=1);

namespace App\Command;

use App\Entity\Article;
use App\Repository\ArticleRepositoryInterface;
use App\Service\CatalogServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ParseArticlesCommand extends Command
{
    protected static $defaultName = 'parseArticles';
    private ArticleRepositoryInterface $storage;
    private CatalogServiceInterface $catalog;

    /**
     * ParseArticlesCommand constructor.
     * @param ArticleRepositoryInterface $storage
     * @param CatalogServiceInterface $catalog
     */
    public function __construct(ArticleRepositoryInterface $storage, CatalogServiceInterface $catalog)
    {
        $this->storage = $storage;
        $this->catalog = $catalog;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Parsing Articles')
            ->addArgument('count', InputArgument::OPTIONAL, 'Number of Articles')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $count = $input->getArgument('count');

        $io->title($this->getDescription());

        if (!$count) {
            $io->warning(sprintf('You passed an argument: %s', 'count'));
            return 128;
        }

        $list = $this->catalog->getList();

        foreach ($list as $item) {
            $article = new Article();
            $article
                ->setTitle($item['title'])
                ->setContent($item['content'])
                ->setImage($item['image']);
            $this->storage->save($article);
        }

        $io->success('Success!');

        return 0;
    }
}
