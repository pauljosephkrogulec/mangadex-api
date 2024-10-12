<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Genre;
use App\Entity\Language;
use App\Entity\Manga;
use App\Entity\MangaTranslation;
use App\Entity\User;
use App\Entity\Chapter;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        // Create Users
        $users = [];
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setUsername("User{$i}")
                ->setEmail("user{$i}@example.com")
                ->setPassword($this->passwordHasher->hashPassword($user, 'password'))
                ->setRoles(['ROLE_USER']);
            $manager->persist($user);
            $users[] = $user;
        }

        // Create Genres
        $genres = [];
        $genreNames = ['Action', 'Adventure', 'Fantasy', 'Romance', 'Horror'];
        foreach ($genreNames as $name) {
            $genre = new Genre();
            $genre->setName($name);
            $manager->persist($genre);
            $genres[] = $genre;
        }

        // Create Languages
        $languages = [];
        $languageNames = [
            ['name' => 'English', 'code' => 'en'],
            ['name' => 'Japanese', 'code' => 'ja'],
            ['name' => 'Spanish', 'code' => 'es'],
        ];
        foreach ($languageNames as $languageData) {
            $language = new Language();
            $language->setName($languageData['name'])
                ->setCode($languageData['code']);
            $manager->persist($language);
            $languages[] = $language;
        }

        // Define a list of authors
        $authors = [
            'Eiichiro Oda',
            'Masashi Kishimoto',
            'Akira Toriyama',
            'Hiro Mashima',
            'Tite Kubo'
        ];

        // Create Manga
        $mangas = [];
        for ($i = 0; $i < 10; $i++) {
            $manga = new Manga();
            $manga->setTitle("Manga Title {$i}")
                ->setDescription("Description for Manga {$i}")
                ->setCoverImage("https://example.com/image{$i}.jpg")
                ->setAuthor($authors[array_rand($authors)]) // Random author
                ->addGenre($genres[array_rand($genres)]) // Random genre
                ->setStatus("Ongoing");
            $manager->persist($manga);
            $mangas[] = $manga;
        }

        // Create Chapters
        for ($i = 0; $i < 5; $i++) {
            $chapter = new Chapter();
            $chapter->setTitle("Chapter {$i}")
                ->setChapterNumber($i + 1)
                ->setManga($mangas[array_rand($mangas)]); // Random manga
            $manager->persist($chapter);
        }

        // Create Manga Translations
        foreach ($mangas as $manga) {
            foreach ($languages as $language) {
                $mangaTranslation = new MangaTranslation();
                $mangaTranslation->setManga($manga)
                    ->setLanguage($language)
                    ->setTitle($manga->getTitle() . " ({$language->getName()})")
                    ->setChapters(['Chapter 1' => 'Translated content...']);

                $manager->persist($mangaTranslation);
            }
        }

        // Flush all data to the database
        $manager->flush();
    }
}
