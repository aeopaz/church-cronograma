<?php

namespace App\Notifications;

use App\Models\ParticipantesProgramacionMinisterio;
use App\Models\Programacion;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AsignacionCompromiso extends Notification
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
        return ['database', 'mail'];
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
            ->subject('Te asignaron un privilegio')
            ->line('Te han asignado la función de '.$this->participantePrograma->nombreRol.' para el programa '.$this->participantePrograma->nombrePrograma.' del día '.$this->participantePrograma->fechaPrograma . " Hora: " . $this->participantePrograma->horaProgram)
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
            'Notificacion' => 'Asignar_Compromiso',
            'Horario' => $this->participantePrograma->fechaPrograma . " Hora: " . $this->participantePrograma->horaProgram,
            'Programa' => $this->participantePrograma->nombrePrograma,
            'Funcion' => $this->participantePrograma->nombreRol,
            'Lugar' => $this->participantePrograma->lugar,
        ];
    }
}
