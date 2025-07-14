<div>
    <x-modal :title="__('Editar Produto #:id', ['id' => $produto?->id])" wire blur size="6xl" z-index="z-40">
        <form id="produto-update-{{ $produto?->id }}" wire:submit="save" class="space-y-6">
            <div class="grid md:grid-cols-12 gap-6 items-start">
                <!-- Imagem  -->
                <div class="md:col-span-3 space-y-2">
                    <div>
                        @if ($imagemTemp)
                            <img src="{{ $imagemTemp->temporaryUrl() }}" class="rounded-lg w-full max-h-48 object-cover">
                        @elseif($produto?->imagem)
                            <img src="{{ 'storage/' . $produto?->imagem }}"
                                class="rounded-lg w-full max-h-48 object-cover">
                        @else
                            <img src="{{ asset('assets/images/no-image.png') }}"
                                class="rounded-lg w-full max-h-48 object-cover">
                        @endif
                    </div>

                    @if ($errors->get('imagemTemp'))
                        <span class="text-red-500 text-sm">{{ $errors->first('imagemTemp') }}</span>
                    @endif
                    @if ($errors->get('produto.imagem'))
                        <span class="text-red-500 text-sm">{{ $errors->first('produto.imagem') }}</span>
                    @endif

                    <x-upload close-after-upload tip="Arraste e Solte a imagem aqui" wire:model='imagemTemp' required
                        :preview="false" />
                </div>

                <!-- Coluna de Inputs -->
                <div class="md:col-span-9 space-y-4">

                    <div class="grid md:grid-cols-2 gap-4">
                        <x-input label="Nome *" x-ref="name" wire:model="produto.nome" required />
                        <x-input label="SKU *" wire:model="produto.sku" required />

                        <div class="md:col-span-2">
                            <x-select.styled :limit="3" label="{{ __('Categorias') }} *"
                                placeholder="Selecione uma categoria" wire:model="categorias_selecionadas"
                                :options="$categorias" select="label:nome|value:id" multiple />
                        </div>
                    </div>

                    <!-- Unidade e Data -->
                    <div class="grid md:grid-cols-2 gap-4">
                        <x-select.native label="Unidade *" wire:model="produto.unidade" :options="[
                            ['name' => 'UN', 'id' => 'UN'],
                            ['name' => 'CX', 'id' => 'CX'],
                            ['name' => 'MT', 'id' => 'MT'],
                            ['name' => 'EM', 'id' => 'EM'],
                        ]"
                            select="label:name|value:id" required />

                        <x-input label="Data Validade *" type="date" wire:model="produto.data_validade" required />
                    </div>


                    <div class="grid md:grid-cols-3 gap-4">
                        <x-currency mutate locale="pt-BR" symbol="R$" label="Preço Padrão *"
                            wire:model="produto.preco_padrao" required />

                        <x-select.native label="Tipo Produto *" wire:model="produto.tipo" :options="[['name' => 'Fisico', 'id' => 'F'], ['name' => 'Digital', 'id' => 'D'], ['name' => 'Serviço', 'id' => 'S']]"
                            select="label:name|value:id" required />

                        <x-select.native label="Status *" wire:model="produto.status" :options="[['name' => 'Ativo', 'id' => 'A'], ['name' => 'Inativo', 'id' => 'I']]"
                            select="label:name|value:id" required />

                        <div class="md:col-span-3">
                            <x-select.styled :limit="5" label="{{ __('Tags') }} *"
                                placeholder="Selecione uma ou mais tags" wire:model="tags_selecionadas"
                                :options="$tags" select="label:nome|value:id" multiple />
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="produto-update-{{ $produto?->id }}">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>

</div>
