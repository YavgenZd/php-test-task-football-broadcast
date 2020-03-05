<?php

namespace App\Entity;

class Team
{
    private string $name;
    private string $country;
    private string $logo;

    /**
     * @var Player[]
     */
    private array $players;
    private string $coach;
    private int $goals;
    private array $positions_time;

    public function __construct(string $name, string $country, string $logo, array $players, string $coach)
    {
        $this->assertCorrectPlayers($players);

        $this->name = $name;
        $this->country = $country;
        $this->logo = $logo;
        $this->players = $players;
        $this->coach = $coach;
        $this->goals = 0;
        $this->positions_time = [
            'Нападающий' => 0,
            'Защитник' => 0,
            'Полузащитник' => 0,
            'Вратарь' => 0,
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getLogo(): string
    {
        return $this->logo;
    }

    /**
     * @return Player[]
     */
    public function getPlayersOnField(): array
    {
        return array_filter($this->players, function (Player $player) {
            return $player->isPlay();
        });
    }

    public function getPlayers(): array
    {
        return $this->players;
    }

    public function getPlayer(int $number): Player
    {
        foreach ($this->players as $player) {
            if ($player->getNumber() === $number) {
                return $player;
            }
        }

        throw new \Exception(
            sprintf(
                'Player with number "%d" not play in team "%s".',
                $number,
                $this->name
            )
        );
    }

    public function getCoach(): string
    {
        return $this->coach;
    }

    public function addGoal(): void
    {
        $this->goals += 1;
    }

    public function setPositionsTime(): void
    {
        $players = $this->getPlayers();

        foreach ($players as $player){
            $player_position = $player->getPosition();
            $player_time = $player->getPlayTime();

            if(array_key_exists($player_position, $this->positions_time)) {
                $this->positions_time[$player_position] += $player_time;
            }
        }
    }

    public function getGoals(): int
    {
        return $this->goals;
    }

    public function getPositionsTime(): array
    {
        return $this->positions_time;
    }

    private function assertCorrectPlayers(array $players)
    {
        foreach ($players as $player) {
            if (!($player instanceof Player)) {
                throw new \Exception(
                    sprintf(
                        'Player should be instance of "%s". "%s" given.',
                        Player::class,
                        get_class($player)
                    )
                );
            }
        }
    }
}