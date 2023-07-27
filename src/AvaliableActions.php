<?php
namespace taskforce;


use taskforce\actions\CancelAction;
use taskforce\actions\CompleteAction;
use taskforce\actions\DenyAction;
use taskforce\actions\RespondAction;
use taskforce\exceptions\RoleException;
use taskforce\exceptions\StatusException;

require_once(__DIR__ . '/../vendor/autoload.php');

class AvaliableActions
{

    const STATUS_NEW = "new";
    const STATUS_CANCELED = "canceled";
    const STATUS_IN_PROGRESS = "in progress";
    const STATUS_COMPLETED = "completed";
    const STATUS_FAILED = "failed";


    const ACTION_CANCEL = "action_cancel";
    const ACTION_RESPOND = "action_respond";
    const ACTION_COMPLETE = "action_complete";
    const ACTION_DENY = "action_deny";

    const ROLE_CLIENT = "client";
    const ROLE_EXECUTIONER = "executioner";

    private ?int $executionerID;
    private ?int $customerID;
    private ?string $status;

    /**
     * AvaliableActions Constructor
     * @param string $status Текущий статус
     * @param int $customerID ID заказчика
     * @param int|null $executionerID ID исполнителя
     */
    function __construct(string $status, int $customerID, ?int $executionerID = null){

        $this->setStatus($status);

        $this->executionerID = $executionerID;
        $this->customerID = $customerID;

    }

    /**
     * Устанавливает переданный в конструкторе статус
     * @param string $status Текущий статус
     * @return void
     */
    public function setStatus(string $status): string {

        $avaliableStatuses = [self::STATUS_NEW, self::STATUS_CANCELED, self::STATUS_COMPLETED, self::STATUS_FAILED, self::STATUS_IN_PROGRESS];

        if(!in_array($status, $avaliableStatuses)){
            throw new StatusException("Неизвестный статус : $status");
        }

        return $this->status = $status;

    }

    /**
     * Проверяет существует ли указанная роль
     * @param string $role Передаваемое значение роли
     * @return void
     */
    public function checkRole(string $role): void {

        $avaliableRoles = [self::ROLE_CLIENT, self::ROLE_EXECUTIONER];

        if(!in_array($role, $avaliableRoles)){
            throw new RoleException("Роль $role не определена");
        }
    }

    /**
     * Получает карту всех статусов
     * @return array
     */
    public function getStatusesMap(): array {
        return [
            self::STATUS_NEW => 'Новое',
            self::STATUS_CANCELED => 'Отменено',
            self::STATUS_IN_PROGRESS => 'В работе',
            self::STATUS_COMPLETED => 'Выполнено',
            self::STATUS_FAILED => 'Провалено'
        ];
    }

    /**
     * Получает карту всех действий
     * @return array
     */
    public function getActionsMap(): array {
        return [
            self::ACTION_CANCEL => 'Отменить',
            self::ACTION_RESPOND => 'Откликнуться',
            self::ACTION_COMPLETE => 'Выполнено',
            self::ACTION_DENY => 'Отказаться'
        ];
    }

    /**
     * Получает статус после конкретного действия
     * @param string $action Действие
     * @return string|null
     */

    public function getNextStatus(string $action): ?string {

    $map =

    [
        self::ACTION_CANCEL => self::STATUS_CANCELED,
        self::ACTION_DENY => self::STATUS_CANCELED,
        self::ACTION_COMPLETE => self::STATUS_COMPLETED,
        self::ACTION_RESPOND => self::STATUS_IN_PROGRESS
    ];

    return $map ?? null;

    }

    /**
     * Возвращает доступные действия при конкретном статусе
     * @return array|null
     */
    public function statusAvaliableActions(): array {

        $map = [

            self::STATUS_IN_PROGRESS => [CompleteAction::class, DenyAction::class],
            self::STATUS_NEW => [RespondAction::class, CancelAction::class]

        ];
        
        return $map ?? null;

    }

    /**
     * Возвращает массив с действиями для статуса
     * @return array|null
     */
    public function roleAvaliableActions(): array {

        $map = [
            self::ROLE_EXECUTIONER => [DenyAction::class, RespondAction::class],
            self::ROLE_CLIENT => [CompleteAction::class, CancelAction::class]
        ];

        return $map ?? null;
    }

    /**
     * @param string $role Текущая роль
     * @param int $id Идентификатор текущего пользователя
     * @return array Возвращает массив значений доступных действий
     */
    public function getAvaliableActions(string $role, int $id): array {

        $statusActions = $this->statusAvaliableActions()[$this->status];
        $roleActions = $this->roleAvaliableActions()[$role];

        $allowedActions = array_intersect($statusActions, $roleActions);

        $allowedActions = array_filter($allowedActions, function ($action) use ($id) {
            return $action::checkRights($id, $this->executionerID, $this->customerID);
        });

        return array_values($allowedActions);
    }

}

$obj = new AvaliableActions("new", 1, 2);
var_dump($obj);