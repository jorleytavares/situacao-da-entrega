@props(['name', 'type' => 'default', 'size' => 24, 'color' => 'currentColor', 'class' => ''])

@php
$svgContent = '';

// Ilustrações Complexas / Premium
switch ($name) {
case 'hero-illustration':
// Uma ilustração de caixa sendo escaneada ou entregue
$svgContent = '
<path d="M12 2L2 7L12 12L22 7L12 2Z" fill="#25D366" opacity="0.8" />
<path d="M2 17L12 22L22 17" stroke="#128C7E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
<path d="M2 12L12 17L22 12" stroke="#128C7E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
<path d="M12 22V12" stroke="#128C7E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
<circle cx="12" cy="7" r="3" fill="white" opacity="0.5" />
';
break;

case 'truck':
$svgContent = '
<path d="M1 3H23V16H1V3ZM1 16C1 17.1 1.9 18 3 18H21C22.1 18 23 17.1 23 16V16H1V16ZM6 21H18V18H6V21Z" stroke="'.$color.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
<rect x="3" y="5" width="10" height="8" rx="1" fill="'.$color.'" opacity="0.1" />
';
break;

case 'package-search':
$svgContent = '
<path d="M21 16.5C21 16.8978 20.842 17.2794 20.5607 17.5607C20.2794 17.842 19.8978 18 19.5 18H5C4.20435 18 3.44129 17.6839 2.87868 17.1213C2.31607 16.5587 2 15.7956 2 15V9C2 8.20435 2.31607 7.44129 2.87868 6.87868C3.44129 6.31607 4.20435 6 5 6H19.5C19.8978 6 20.2794 6.15804 20.5607 6.43934C20.842 6.72064 21 7.10218 21 7.5V16.5ZM17 12L23 9V15L17 12Z" stroke="'.$color.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
<circle cx="10" cy="12" r="3" stroke="'.$color.'" stroke-width="2" />
<path d="M12.5 14.5L14.5 16.5" stroke="'.$color.'" stroke-width="2" stroke-linecap="round" />
';
break;

case 'encomenda-parada':
case 'pause-circle':
$svgContent = '
<circle cx="12" cy="12" r="10" stroke="'.$color.'" stroke-width="2" />
<rect x="9" y="8" width="2" height="8" fill="'.$color.'" />
<rect x="13" y="8" width="2" height="8" fill="'.$color.'" />
';
break;

case 'entrega-atrasada':
case 'clock-alert':
$svgContent = '
<circle cx="12" cy="12" r="10" stroke="'.$color.'" stroke-width="2" />
<polyline points="12 6 12 12 16 14" stroke="'.$color.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
<path d="M12 2V4" stroke="'.$color.'" stroke-width="2" stroke-linecap="round" />
';
break;

case 'objeto-nao-localizado':
case 'search-x':
$svgContent = '
<circle cx="10" cy="10" r="7" stroke="'.$color.'" stroke-width="2" />
<path d="M21 21L15 15" stroke="'.$color.'" stroke-width="2" stroke-linecap="round" />
<path d="M8 8L12 12M12 8L8 12" stroke="'.$color.'" stroke-width="2" stroke-linecap="round" />
';
break;

case 'fiscalizacao':
case 'shield-alert':
$svgContent = '
<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="'.$color.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
<line x1="12" y1="8" x2="12" y2="12" stroke="'.$color.'" stroke-width="2" stroke-linecap="round" />
<line x1="12" y1="16" x2="12.01" y2="16" stroke="'.$color.'" stroke-width="2" stroke-linecap="round" />
';
break;

case 'nao-saiu-para-entrega':
case 'home-x':
$svgContent = '
<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" stroke="'.$color.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
<path d="M9 22V12h6v10" stroke="'.$color.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
<circle cx="18" cy="18" r="4" fill="white" stroke="'.$color.'" stroke-width="2" />
<path d="M16 16l4 4M20 16l-4 4" stroke="'.$color.'" stroke-width="1.5" stroke-linecap="round" />
';
break;

// Ícones genéricos anteriores...
case 'alert-triangle':
$svgContent = '
<path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" stroke="'.$color.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
<line x1="12" y1="9" x2="12" y2="13" stroke="'.$color.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
<line x1="12" y1="17" x2="12.01" y2="17" stroke="'.$color.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
';
break;

case 'clock':
$svgContent = '
<circle cx="12" cy="12" r="10" stroke="'.$color.'" stroke-width="2" />
<polyline points="12 6 12 12 16 14" stroke="'.$color.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
';
break;

case 'check-circle':
$svgContent = '
<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" stroke="'.$color.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
<polyline points="22 4 12 14.01 9 11.01" stroke="'.$color.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
';
break;

case 'home':
$svgContent = '
<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" stroke="'.$color.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
<polyline points="9 22 9 12 15 12 15 22" stroke="'.$color.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
';
break;

// Adicione mais ícones conforme necessário
default:
// Fallback (círculo)
$svgContent = '
<circle cx="12" cy="12" r="10" stroke="'.$color.'" stroke-width="2" />';
}
@endphp

<svg
    width="{{ $size }}"
    height="{{ $size }}"
    viewBox="0 0 24 24"
    fill="none"
    xmlns="http://www.w3.org/2000/svg"
    class="{{ $class }}"
    role="img"
    aria-hidden="true">
    {!! $svgContent !!}
</svg>