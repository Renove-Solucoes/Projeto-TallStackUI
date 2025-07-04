<div x-data="{
    data_de: @entangle($modelDataDe),
    data_ate: @entangle($modelDataAte),
    periodo: @entangle($filtroPeriodo),

    atualizarDatasPorPeriodo() {
        const hoje = new Date();
        const format = d => d.toISOString().slice(0, 10);

        switch (this.periodo) {
            case '1':
                this.data_de = this.data_ate = format(hoje);
                break;
            case '2':
                const inicioSemana = new Date(hoje);
                inicioSemana.setDate(hoje.getDate() - hoje.getDay());
                const fimSemana = new Date(inicioSemana);
                fimSemana.setDate(inicioSemana.getDate() + 6);
                this.data_de = format(inicioSemana);
                this.data_ate = format(fimSemana);
                break;
            case '3':
                const inicioSP = new Date(hoje);
                inicioSP.setDate(hoje.getDate() - hoje.getDay() - 7);
                const fimSP = new Date(inicioSP);
                fimSP.setDate(inicioSP.getDate() + 6);
                this.data_de = format(inicioSP);
                this.data_ate = format(fimSP);
                break;
            case '4':
                const inicioMes = new Date(hoje.getFullYear(), hoje.getMonth(), 1);
                const fimMes = new Date(hoje.getFullYear(), hoje.getMonth() + 1, 0);
                this.data_de = format(inicioMes);
                this.data_ate = format(fimMes);
                break;
            case '5':
                const inicioMP = new Date(hoje.getFullYear(), hoje.getMonth() - 1, 1);
                const fimMP = new Date(hoje.getFullYear(), hoje.getMonth(), 0);
                this.data_de = format(inicioMP);
                this.data_ate = format(fimMP);
                break;
            case '6':
                const ano = hoje.getFullYear();
                this.data_de = `${ano}-01-01`;
                this.data_ate = `${ano}-12-31`;
                break;
            case '7':
                const anoPassado = hoje.getFullYear() - 1;
                this.data_de = `${anoPassado}-01-01`;
                this.data_ate = `${anoPassado}-12-31`;
                break;
            default:
                this.data_de = '';
                this.data_ate = '';
        }
    }
}" class="flex flex-col md:flex-row gap-4">
    <div class="w-full md:w-1/3">
        <x-select.native label="{{ $labelPeriodo ?? 'Período' }}" :options="[
            ['name' => '', 'id' => '0'],
            ['name' => 'Hoje', 'id' => '1'],
            ['name' => 'Esta Semana', 'id' => '2'],
            ['name' => 'Semana passada', 'id' => '3'],
            ['name' => 'Este Mês', 'id' => '4'],
            ['name' => 'Mês passado', 'id' => '5'],
            ['name' => 'Este Ano', 'id' => '6'],
            ['name' => 'Ano passado', 'id' => '7'],
        ]" select="label:name|value:id"
            x-model="periodo" @change="atualizarDatasPorPeriodo()" required />
    </div>

    <div class="w-full md:w-1/3">
        <x-input label="{{ $labelDataDe ?? 'Nascimento de' }}" type="date" wire:model="{{ $modelDataDe }}"
            x-model="data_de" x-on:blur="if (!data_ate) data_ate = data_de" maxlength="10" />
    </div>

    <div class="w-full md:w-1/3">
        <x-input label="{{ $labelDataAte ?? 'Nascimento até' }}" type="date" wire:model="{{ $modelDataAte }}"
            x-model="data_ate" maxlength="10" />
    </div>
</div>
