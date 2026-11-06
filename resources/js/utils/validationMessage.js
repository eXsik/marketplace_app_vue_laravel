const labels = {
    title: 'Tytuł',
    description: 'Opis',
    tags: 'Tagi',
    email: 'E-mail',
    link: 'Link',
    image: 'Zdjęcie',
    name: 'Imię i nazwisko',
    password: 'Hasło',
    password_confirmation: 'Potwierdzenie hasła',
    current_password: 'Obecne hasło',
    role: 'Rola',
};

export const validationMessage = (message, field) => {
    if (!message) return message;

    const label = labels[field] ?? field ?? 'To pole';

    if (/^The .+ field is required\.$/i.test(message)) {
        return `${label} jest wymagane.`;
    }
    if (/^The .+ field must be a valid email address\.$/i.test(message)) {
        return 'Wpisz poprawny adres e-mail.';
    }
    if (/^The .+ field must be a valid URL\.$/i.test(message)) {
        return 'Wpisz poprawny adres strony, np. https://example.com.';
    }
    if (/^The .+ field confirmation does not match\.$/i.test(message)) {
        return 'Wpisane wartości nie są takie same.';
    }

    const characterLimit = message.match(
        /^The .+ field must not be greater than (\d+) characters\.$/i,
    );
    if (characterLimit)
        return `${label} może mieć maksymalnie ${characterLimit[1]} znaków.`;

    const minimumCharacters = message.match(
        /^The .+ field must be at least (\d+) characters\.$/i,
    );
    if (minimumCharacters)
        return `${label} musi mieć co najmniej ${minimumCharacters[1]} znaków.`;

    const fileLimit = message.match(
        /^The .+ field must not be greater than (\d+) kilobytes\.$/i,
    );
    if (fileLimit)
        return `Plik może mieć maksymalnie ${Math.round(Number(fileLimit[1]) / 1024)} MB.`;

    return message;
};
