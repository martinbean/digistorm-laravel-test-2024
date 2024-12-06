<div class="bg-white mb-4 p-4 rounded shadow">
    <div
        class="flex flex-col gap-0"
        x-data="{
            {{-- Bit of a hack, as @json directive outputs double quotes, which breaks scope --}}
            numbers: JSON.parse('{{ json_encode($value) }}'),
            init() {
                if (this.numbers.length === 0) {
                    // Add a default number input
                    this.numbers.push('');
                }
            },
            addRow() {
                // Only add row if last one is not empty
                var last = String(this.numbers.slice(-1));

                if (last.trim() === '') {
                    return;
                }

                this.numbers.push('');
            },
            removeRow(index) {
                // Only allow removing row if there is more than one
                if (this.numbers.length > 1) {
                    this.numbers.splice(index, 1);
                }
            },
        }"
    >
        <div class="mb-2">
            <p class="font-medium">{{ __('Phone numbers') }}</p>
        </div>
        <div class="flex flex-col gap-3 mb-3">
            <template x-for="(number, index) in numbers">
                <div class="flex gap-2">
                    <div class="flex grow">
                        <input class="form-control" name="number[]" required type="tel" x-model="numbers[index]">
                    </div>
                    <div>
                        <button class="btn btn-danger" type="button" x-bind:disabled="numbers.length === 1" x-on:click="removeRow(index)">{{ __('Remove') }}</button>
                    </div>
                </div>
            </template>
        </div>
        <div>
            <button class="btn btn-primary btn-sm" type="button" x-on:click="addRow">{{ __('Add phone number') }}</button>
        </div>
    </div>
</div>
