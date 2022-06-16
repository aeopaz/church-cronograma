<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CancelacionCompromiso extends Notification
{
    use Queueable;
    public $participantePrograma;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($participantePrograma)
    {
       
        $this->participantePrograma = $participantePrograma;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('¡Dios te bendiga!')
            ->subject('Te cancelaron un compromiso')
            ->line('El compromiso de '.$this->participantePrograma->nombreRol.' para el programa '.$this->participantePrograma->nombrePrograma.' del día '.$this->participantePrograma->fechaPrograma . " Hora: " . $this->participantePrograma->horaProgram.' ha sido cancelado.')
            ->action('Entrar al sistema', url('/'))
            ->line('Permanece firme y nunca dejes de trabajar más y más por el Señor Jesús, porque que nada de lo que hagas para Dios es en vano.');
    
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'Notificacion'=>'Cancelar_Compromiso',
            'Horario' => $this->participantePrograma->fechaPrograma . " Hora: " . $this->participantePrograma->horaProgram,
            'Programa' => $this->participantePrograma->nombrePrograma,
            'Funcion' => $this->participantePrograma->nombreRol,
            'Lugar' => $this->participantePrograma->lugar,
        ];
    }
}
