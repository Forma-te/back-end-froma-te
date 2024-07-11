<section id="plan-creation" class="menu-area gap-y-2">
    <button id="plan:create-plan" data-event="toggle-form" data-targetid="create-plan-form" type="button" class="w-full fmt-button" data-styletype="primary" data-theme="light">
        {{ $data->translation->plan_createPlan }}
    </button>

    <form 
        id="create-plan-form" 
        class="section-form" 
        data-toggled="false" 
        action="{{ route('plans.create') }}" method="POST"
    >
        <h3>Cadastrar plano</h3>

        <label for="new-plan-name" class="w-full">
            <span>Nome</span>

            <input type="text" id="new-plan-name" class="w-full" name="name" placeholder="Nome do plano" />
        </label>

        <label for="new-plan-description" class="w-full">
            <span>Descrição</span>

            <textarea id="new-plan-description" class="w-full" name="description" placeholder="Descrição">
            </textarea>
        </label>

        <div class="flex flex-row justify-start items-center gap-x-2">
            <label for="new-plan-price">
                <span>Preço</span>

                <input type="number" id="new-plan-price" name="price" min="0" placeholder="Preço"/>
            </label>

            <label for="new-plan-qty">
                <span>Quantidade</span>

                <input type="number" id="new-plan-qty" name="quanity" min="1" placeholder="Quantidade" />
            </label>
        </div>

        <div class="publish-row">
            <input type="checkbox" id="new-plan-publish" name="publish?" />

            <label for="new-plan-publish">
                Publicar?
            </label>
        </div>
        
        <button id="plan:create-plan-submit" type="button" class="w-full fmt-button" data-styletype="special" data-theme="light">
            {{ $data->translation->plan_createPlanSubmit }}
        </button>
    </form>
</section>

<h3>Planos</h3>

<section id="plan-list" class="menu-area gap-y-2">
    @forelse ($plans as $plan) 
        <form 
            id="{{"{$plan->id}-form"}}" class="plan-form" data-styletype="primary" data-theme="light"
            action="{{ route('plans.update', $plan->id) }}" method="POST"
        >
            <label class="name" for="{{"plan-{$plan->id}"}}">
                <span>Nome</span>

                <input type="text" name="name" id="{{"plan-{$plan->id}"}}" value="{{$plan->name}}" />
            </label>

            <label class="price" for="{{"plan-{$plan->id}-price"}}">
                <span>Preço</span>

                <input type="number" name="price" id="{{"plan-{$plan->id}-price"}}" value="{{$plan->price}}" min="0" />
            </label>

            <div class="actions">
                <button 
                    type="button" 
                    title="{{"Salvar alterações do plano '{$plan->name}'"}}" 
                    data-action="save-changes" 
                    data-entity="plan" 
                    data-event="api" 
                    class="fmt-button-circle" 
                    data-styletype="approved"
                >
                    <i class="fa fa-save"></i>
                </button>

                <button 
                    type="button" 
                    title="{{"Eliminar plano '{$plan->name}'"}}" 
                    data-action="delete" 
                    data-entity="plan" 
                    data-event="api" 
                    class="fmt-button-circle" 
                    data-styletype="dangerous"
                >
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </form>
    @empty
        <div class="w-full flex flex-row justify-center items-center">
            Cria um plano
        </div>
    @endforelse
</section>