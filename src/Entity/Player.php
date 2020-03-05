<?php
namespace App\Entity;

class Player
{
    private const PLAY_PLAY_STATUS = 'play';
    private const BENCH_PLAY_STATUS = 'bench';

    private const POSITION_STRIKER = 'Н';
    private const POSITION_DEFENDER = 'З';
    private const POSITION_MIDFIELDER = 'П';
    private const POSITION_GATEKEEPER = 'В';

    private int $number;
    private string $name;
    private string $playStatus;
    private int $inMinute;
    private int $outMinute;
    private int $goals;
    private int $yellow_cards;
    private int $red_card;
    private array $positions;
    private string $position;

    public function __construct(int $number, string $name, string $position)
    {
        $this->number = $number;
        $this->name = $name;
        $this->playStatus = self::BENCH_PLAY_STATUS;
        $this->inMinute = 1;
        $this->outMinute = 0;
        $this->goals = 0;
        $this->yellow_cards = 0;
        $this->red_card = 0;
        $this->positions = [
            self::POSITION_STRIKER => 'Нападающий',
            self::POSITION_DEFENDER => 'Защитник',
            self::POSITION_MIDFIELDER => 'Полузащитник',
            self::POSITION_GATEKEEPER => 'Вратарь'
        ];
        $this->setPosition($position);
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getInMinute(): int
    {
        return $this->inMinute;
    }

    public function getOutMinute(): int
    {
        return $this->outMinute;
    }

    public function getGoals(): int
    {
        return $this->goals;
    }

    public function getYellowCards(): int
    {
        return $this->yellow_cards;
    }

    public function getRedCards(): int
    {
        return $this->red_card;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function addGoal(): void
    {
        $this->goals += 1;
    }

    public function addYellowCard(): void
    {
        $this->yellow_cards += 1;
    }

    public function addRedCard(): void
    {
        $this->red_card = 1;
    }

    public function setPosition(string $position): void
    {
        if(array_key_exists($position, $this->positions)) {
            $this->position = $this->positions[$position];
        }
    }

    public function isPlay(): bool
    {
        return $this->playStatus === self::PLAY_PLAY_STATUS;
    }

    public function getPlayTime(): int
    {
        if(!$this->outMinute) {
            return 0;
        }

        return $this->outMinute - $this->inMinute;
    }

    public function goToPlay(int $minute): void
    {
        $this->inMinute = $minute;
        $this->playStatus = self::PLAY_PLAY_STATUS;
    }

    public function goToBench(int $minute): void
    {
        $this->outMinute = $minute;
        $this->playStatus = self::BENCH_PLAY_STATUS;
    }

}