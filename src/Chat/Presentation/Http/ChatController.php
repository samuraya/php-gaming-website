<?php
declare(strict_types=1);

namespace Gaming\Chat\Presentation\Http;

use Gaming\Chat\Application\ChatService;
use Gaming\Chat\Application\Command\WriteMessageCommand;
use Gaming\Chat\Application\Query\MessagesQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class ChatController
{
    /**
     * @var ChatService
     */
    private $chatService;

    /**
     * ChatController constructor.
     *
     * @param ChatService $chatService
     */
    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function writeMessageAction(Request $request): JsonResponse
    {
        $chatId = $request->query->get('chatId');

        $this->chatService->writeMessage(
            new WriteMessageCommand(
                $chatId,
                $request->request->get('authorId'),
                $request->request->get('message')
            )
        );

        return new JsonResponse([
            'chatId' => $chatId
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function messagesAction(Request $request): JsonResponse
    {
        return new JsonResponse(
            $this->chatService->messages(
                new MessagesQuery(
                    $request->query->get('chatId'),
                    $request->query->get('authorId'),
                    (int)$request->query->get('offset'),
                    (int)$request->query->get('limit')
                )
            )
        );
    }
}
