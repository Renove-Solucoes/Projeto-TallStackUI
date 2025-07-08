<div>
    <x-card>
        <x-table stripped striped :sort :$headers :rows="$this->rows" paginate filter :quantity="[5, 10, 20]" :placeholders="['search' => 'Pesquisar por nome, email ou CPF']">

        </x-table>
    </x-card>
</div>
