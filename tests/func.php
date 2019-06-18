<?php
declare(strict_types=1);

final class Email
{
    private $email;

    private function __construct(string $email)
    {
        $this->ensureIsValidEmail($email);

        $this->email = $email;
    }

    public static function fromString(string $email): self
    {
        return new self($email);
    }

    public function __toString(): string
    {
        return $this->email;
    }

    private function ensureIsValidEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(
                sprintf(
                    '"%s" is not a valid email address',
                    $email
                )
            );
        }
    }
}



$ori = "A:\Auto beauty ecommerce pictures";
$tar = 'A:\_NEW Ecommerce pictures\B空的';

$dirs = array_filter(glob($tar), 'is_dir');
print_r( $dirs);

// if (!copy($file, $newfile)) {
//     echo "failed to copy $file...\n";
// }


// $file = file_get_contents("ttt.ext");
// print($file);