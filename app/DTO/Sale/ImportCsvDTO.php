<?php

namespace App\DTO\Sale;

class ImportCsvDTO
{
    public function __construct(
        public string $course_id,
        public ?string $user_id,
        public string $name,
        public ?string $instrutor_id,
        public string $transaction,
        public string $email_student,
        public string $status,
        public string $blocked,
        public string $date_created,
        public string $date_expired,
        public string $product_type
    ) {
    }
    public static function makeFromArray(array $data): self
    {
        $transaction = sprintf('%07X', mt_rand(0, 0xFFFFFFF)); // Geração de transação aleatória
        $date_created = now(); // Data de criação atual
        $blocked = 0; // Bloqueio padrão (desbloqueado)
        $status = 'A'; // Status padrão

        return new self(
            $data['course_id'],
            $data['user_id'] ?? null,
            $data['name'],
            $data['instrutor_id'] ?? null,
            $transaction,
            $data['email_student'],
            $status,
            $blocked,
            $date_created->format('Y-m-d H:i:s'),
            $data['date_expired'],
            $data['product_type']
        );
    }
}
