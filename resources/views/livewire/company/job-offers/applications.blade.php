<div x-data="{ actualJobId: '', actualJob: '' }">
    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Candidatos postulados</h2>
            <p class="text-gray-600">Oferta: {{ $jobOffer->title }}</p>
        </div>

        @if($jobApplications->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                    <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Candidato</th>
                        <th class="py-3 px-6 text-left">Fecha de postulación</th>
                        <th class="py-3 px-6 text-left">Estado</th>
                        <th class="py-3 px-6 text-left">Ver Notas</th>
                        <th class="py-3 px-6 text-center">Ver Hoja De Vida</th>
                        <th class="py-3 px-6 text-center">Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm">
                    @foreach($jobApplications as $jobApplication)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-4 px-6">
                                <p class="font-medium">{{ $jobApplication->candidate->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $jobApplication->candidate->user->email }}</p>
                            </td>
                            <td class="py-4 px-6">
                                {{ $jobApplication->created_at->format('d/m/Y H:i') }}
                                ({{ $jobApplication->created_at->diffForHumans() }})
                            </td>
                            <td class="py-4 px-6">
                                @php
                                    $color = match($jobApplication->status->value) {
                                            'pending' => 'yellow',
                                            'reviewed' => 'blue',
                                            'accepted' => 'green',
                                            'rejected' => 'red',
                                        }
                                @endphp

                                <flux:badge color="{{ $color }}">
                                    @switch($jobApplication->status->value)
                                        @case('pending')
                                            Pendiente
                                            @break

                                        @case('reviewed')
                                            Revisado
                                            @break

                                        @case('accepted')
                                            Aceptado
                                            @break

                                        @case('rejected')
                                            Rechazado
                                            @break
                                    @endswitch
                                </flux:badge>
                            </td>
                            <td>
                                @if($jobApplication->notes)
                                    <flux:button
                                        x-on:click="$flux.modal('showNotes').show(); actualJob = {{ $jobApplication }}">
                                        Ver Notas
                                    </flux:button>
                                @else
                                    <flux:badge>
                                        No hay notas
                                    </flux:badge>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <flux:button href="{{ route('company.cv.pdf', $jobApplication->candidate->cv->id) }}"
                                             target="_blank">
                                    Abrir HV
                                </flux:button>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex justify-center gap-2">
                                    <flux:button
                                        wire:click="updateApplicationStatus({{ $jobApplication->id }}, 'accepted')"
                                        variant="primary" color="green" title="Aceptar candidato">
                                        Aceptar
                                    </flux:button>

                                    <flux:button
                                        x-on:click="$flux.modal('notes').show(); actualJobId = {{ $jobApplication->id }};"
                                        variant="primary" color="red" title="Rechazar candidato">
                                        Rechazar
                                    </flux:button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $jobApplications->links() }}
            </div>
        @else
            <div class="bg-gray-50 p-6 rounded-lg text-center">
                <p class="text-gray-600">Aún no hay candidatos postulados para esta oferta de trabajo.</p>
            </div>
        @endif
    </div>

    <flux:modal name="notes" class="w-lg flex flex-col gap-6">
        <flux:textarea wire:model="notes" label="Notas:" description="Por favor describa porque rechaza al candidato"/>

        <flux:button type="button" variant="danger"
                     x-on:click="$wire.updateApplicationStatus(actualJobId, 'rejected')">
            Rechazar Candidato
        </flux:button>
    </flux:modal>

    <flux:modal name="showNotes" class="w-lg">
        Notas:

        <p x-text="actualJob.notes"></p>
    </flux:modal>
</div>
