<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Game;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->hasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // injection de l'admin
        $admin = new User();
        $admin->setEmail('admin@mail.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->hasher->hashPassword($admin, 'Super@dmin1234'));
        $admin->setFirstName('Admin');
        $admin->setLastName('Super');
        $manager->persist($admin);


        $category1 = new Category();
        $category1->setName('Party');
        $category1->setColor('#FF0000');

        $manager->persist($category1);

        $category2 = new Category();
        $category2->setName('Strategy');
        $category2->setDescription('Strategy games are games in which the players\' uncoerced, and often autonomous, decision-making skills have a high significance in determining the outcome. Almost all strategy games require internal decision tree style thinking, and typically very high situational awareness.');
        $category2->setColor('#4287f5');

        $manager->persist($category2);

        $category3 = new Category();
        $category3->setName('Family');
        $category3->setDescription('Play with your family');
        $category3->setColor('#3bf5eb');

        $manager->persist($category3);

        $category4 = new Category();
        $category4->setName('Cooperative');
        $category4->setDescription('Cooperative board games are board games in which players work together to achieve a common goal, the result being either winning or losing as a group.');
        $category4->setColor('#f5e03b');

        $manager->persist($category4);

        $category5 = new Category();
        $category5->setName('Children');
        $category5->setDescription('Play with your children');
        $category5->setColor('#f5a03b');

        $manager->persist($category5);

        $category6 = new Category();
        $category6->setName('Role Playing');
        $category6->setDescription('A role-playing game is a game in which players assume the roles of characters in a fictional setting. Players take responsibility for acting out these roles within a narrative, either through literal acting, or through a process of structured decision-making regarding character development.');
        $category6->setColor('#f53b3b');

        $manager->persist($category6);

//        Games

        $game1 = new Game();
        $game1->setName('WereWolf');
        $game1->setDescription('WereWolf is a game of deception. Each player is secretly assigned a role - Werewolf, Villager, or Seer (a special Villager). There is also a Moderator who controls the flow of the game. The game alternates between night and day phases. At night, the Werewolves secretly choose a Villager to kill. Also, the Seer (if still alive) asks whether another player is a Werewolf or not. During the day, the Villager who was killed is revealed and is out of the game. The remaining Villagers then vote on the player they suspect is a Werewolf. That player reveals his/her role and is out of the game. Werewolves win when there are an equal number of Villagers and Werewolves. Villagers win when they have killed all Werewolves. Werewolf is a social puzzle game.');
        $game1->setImage('72-les-loups-garous-de-thiercelieux-2019-cover-64f87efb3f659.jpg');
        $game1->addCategory($category1);
        $game1->addCategory($category2);
        $game1->addCategory($category6);

        $manager->persist($game1);

        $game2 = new Game();
        $game2->setName('Top Ten');
        $game2->setDescription('A game about making lists');
        $game2->setImage('Top-ten-face-logo-BD-788x1024-64f885a4e2a69.jpg');
        $game2->addCategory($category1);
        $game2->addCategory($category3);

        $manager->persist($game2);

        $game3 = new Game();
        $game3->setName('Dixit');
        $game3->setDescription('A game about making up stories');
        $game3->setImage('0393061-0-64f885cff33c4.jpg');
        $game3->addCategory($category1);
        $game3->addCategory($category4);

        $manager->persist($game3);

        $game4 = new Game();
        $game4->setName('Dobble');
        $game4->setDescription('A game about finding matching symbols');
        $game4->setImage('dobble-boite-64f885ea79d12.jpg');
        $game4->addCategory($category1);
        $game4->addCategory($category5);

        $manager->persist($game4);

        $game5 = new Game();
        $game5->setName('TAC-TIK');
        $game5->setImage('image-64f88609281e5.jpg');
        $game5->addCategory($category2);
        $game5->addCategory($category3);

        $manager->persist($game5);

        $manager->flush();
    }
}
