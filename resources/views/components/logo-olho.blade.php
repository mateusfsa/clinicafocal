@php
    // Defina os valores padrão, mas permita sobrescrever via parâmetros
    $width = $width ?? 400;
    $height = $height ?? 250;
    $irisColor = $irisColor ?? '#29a8df';
    $pupilColor = $pupilColor ?? '#111';
    $shineColor = $shineColor ?? '#fff';
@endphp

<svg
    width="{{ $width }}"
    height="{{ $height }}"
    viewBox="0 0 {{ $width }} {{ $height }}"
    xmlns="http://www.w3.org/2000/svg"
    style="display:block"
>
    <!-- Esclera (parte branca, oval) -->
    <ellipse
        cx="{{ $width / 2 }}"
        cy="{{ $height / 2 }}"
        rx="{{ $width / 2 }}"
        ry="{{ $height / 2 }}"
        fill="#fff"
        stroke="#aaa"
        stroke-width="6"
        filter="drop-shadow(0 0 12px #bbb)"
    />

    <!-- Íris (círculo central) -->
    <ellipse
        cx="{{ $width / 2 }}"
        cy="{{ $height / 2 }}"
        rx="{{ $width * 0.28 }}"
        ry="{{ $height * 0.37 }}"
        fill="{{ $irisColor }}"
        filter="drop-shadow(0 0 8px #29a8df88)"
    />

    <!-- Pupila -->
    <ellipse
        cx="{{ $width / 2 }}"
        cy="{{ $height / 2 }}"
        rx="{{ $width * 0.11 }}"
        ry="{{ $height * 0.14 }}"
        fill="{{ $pupilColor }}"
    />

    <!-- Brilho (reflexo) -->
    <ellipse
        cx="{{ $width * 0.64 }}"
        cy="{{ $height * 0.38 }}"
        rx="{{ $width * 0.05 }}"
        ry="{{ $height * 0.08 }}"
        fill="{{ $shineColor }}"
        opacity="0.8"
    />
</svg>