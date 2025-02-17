<template>
    <div
        class="min-h-screen bg-gradient-to-r from-purple-600 via-blue-500 to-orange-400 flex items-center justify-center p-6"
    >
        <header
            class="w-full bg-white shadow-md py-4 px-6 fixed top-0 z-50 flex justify-center"
        >
            <img
                src="/public/logo.png"
                alt="Logo"
                class="h-12 object-contain"
            />
        </header>

        <div
            class="max-w-2xl w-full bg-white shadow-2xl rounded-lg p-8 mt-16"
            style="zoom: 0.8; margin-bottom: 20%"
        >
            <!-- Título -->
            <h2
                class="text-4xl font-bold text-center text-purple-700 mb-6 animate-fade-in"
            >
                Consulta de Ofertas de Crédito
            </h2>

            <form
                v-if="!offers.length"
                @submit.prevent="fetchOffers"
                class="flex flex-col space-y-4"
            >
                <label for="cpf" class="font-medium text-gray-700"
                    >Digite o CPF:</label
                >
                <input
                    type="text"
                    v-model="cpf"
                    placeholder="Digite seu CPF"
                    @input="formatCpf"
                    required
                    class="px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
                />
                <button
                    type="submit"
                    :disabled="cpf.replace(/\D/g, '').length !== 11 || loading"
                    class="bg-gradient-to-r from-blue-500 to-purple-600 text-white py-3 px-6 rounded-lg font-bold hover:shadow-lg hover:scale-105 transition transform"
                    :class="{
                        'opacity-50 cursor-not-allowed':
                            cpf.replace(/\D/g, '').length !== 11 || loading,
                        'hover:bg-blue-700':
                            cpf.replace(/\D/g, '').length === 11 && !loading,
                    }"
                >
                    Consultar
                </button>
            </form>

            <!-- Indicador de carregamento -->
            <div
                v-if="loading"
                class="text-center mt-4 text-blue-500 font-semibold"
            >
                <div class="flex justify-center">
                    <span
                        class="animate-spin h-8 w-8 border-4 border-orange-500 border-t-transparent rounded-full"
                    ></span>
                </div>
                <p class="mt-2">Carregando...</p>
            </div>

            <!-- Exibição de erro -->
            <div
                v-if="error && error !== null && error !== ''"
                class="text-red-500 text-center mt-4 bg-red-100 p-3 rounded-md"
            >
                {{ error }}
            </div>

            <!-- Botões extras após consulta -->
            <div v-if="offers.length > 0" class="flex justify-between mt-4">
                <button
                    @click="resetSearch"
                    class="bg-gray-600 text-white py-2 px-4 rounded-lg hover:bg-gray-700 transition"
                >
                    Nova Consulta
                </button>
                <button
                    @click="toggleGraph()"
                    class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition"
                >
                    Comparar Simulações
                </button>
            </div>

            <!-- Tabela de ofertas -->
            <div v-if="offers.length > 0" class="mt-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-3">
                    Ofertas Disponíveis
                </h3>
                <table
                    class="w-full border-collapse border border-gray-300 shadow-md rounded-lg overflow-hidden"
                >
                    <thead>
                        <tr
                            class="bg-gradient-to-r from-purple-600 to-blue-500 text-white"
                        >
                            <th class="border p-4 text-left">Instituição</th>
                            <th class="border p-4 text-left">Modalidade</th>
                            <th class="border p-4 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="offer in offers"
                            :key="offer.id"
                            class="bg-gray-50 hover:bg-gray-200 transition"
                        >
                            <td class="border p-4">
                                {{ offer.institution.name }}
                            </td>

                            <!-- Clicável para exibir simulação salva -->
                            <td
                                class="border p-4 cursor-pointer text-blue-600 hover:underline"
                                @click="loadSavedSimulation(offer)"
                            >
                                {{ offer.modality }}
                            </td>

                            <td class="border p-4 text-center">
                                <button
                                    @click="simulateOffer(offer)"
                                    :disabled="isSimulated(offer)"
                                    :class="{
                                        'bg-orange-500 hover:bg-orange-600':
                                            !isSimulated(offer),
                                        'bg-gray-500 cursor-not-allowed':
                                            isSimulated(offer),
                                    }"
                                    class="text-white px-5 py-2 rounded-lg hover:scale-105 transition"
                                >
                                    Simular
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Resultado da simulação -->
            <div
                v-if="simulation"
                class="mt-6 p-6 bg-white shadow-lg rounded-lg border border-blue-300"
            >
                <h3 class="text-xl font-semibold text-blue-700 mb-2">
                    Detalhes da Simulação
                </h3>
                <p class="text-gray-700">
                    <strong>Valor Mínimo:</strong> R$
                    {{ formatCurrency(simulation.valorMin) }}
                </p>
                <p class="text-gray-700">
                    <strong>Valor Máximo:</strong> R$
                    {{ formatCurrency(simulation.valorMax) }}
                </p>
                <p class="text-gray-700">
                    <strong>Taxa de Juros Mensal:</strong>
                    {{ formatCurrency(simulation.jurosMes * 100) }}%
                </p>
                <p class="text-gray-700">
                    <strong>Parcelas:</strong> {{ simulation.QntParcelaMin }} -
                    {{ simulation.QntParcelaMax }}
                </p>
            </div>

            <!-- Gráfico de comparação -->
            <div
                v-if="showGraph"
                class="mt-8 p-6 bg-gray-100 rounded-lg shadow-md"
            >
                <h3 class="text-xl font-semibold text-center text-gray-800">
                    Comparação de Simulações
                </h3>
                <canvas id="comparisonChart"></canvas>
            </div>
        </div>

        <footer
            class="w-full bg-gray-800 text-white p-4 text-center flex flex-col items-center space-y-3"
            style="
                justify-content: center;
                gap: 8px;
                backdrop-filter: blur(10px);
                background-color: rgba(0, 0, 0, 0.3);
                flex-direction: row;
                bottom: 0;
                position: fixed;
            "
        >
            <img
                src="/public/minha-foto.png"
                alt="Minha Foto"
                class="h-16 w-16 rounded-full shadow-lg"
            />
            <p class="text-lg font-semibold">
                Desenvolvido por
                <a
                    href="https://github.com/acamilateixeira"
                    target="_blank"
                    class="text-white-400 hover:underline"
                    >Camila Teixeira</a
                >
                |
            </p>
            <p>
                <a
                    href="https://github.com/acamilateixeira/gosatAPI"
                    target="_blank"
                    class="text-white-400 hover:underline"
                    >Repositório do Projeto</a
                >
            </p>
        </footer>
    </div>
</template>

<script>
import axios from "axios";
import Chart from "chart.js/auto";

export default {
    data() {
        return {
            cpf: "",
            offers: [],
            loading: false,
            simulation: null,
            error: null,
            showGraph: false,
            simulationsHistory: {}, // Armazena as simulações feitas
            chartInstance: null,
        };
    },
    methods: {
        formatCpf() {
            this.cpf = this.cpf
                .replace(/\D/g, "")
                .replace(/(\d{3})(\d)/, "$1.$2")
                .replace(/(\d{3})\.(\d{3})(\d)/, "$1.$2.$3")
                .replace(/(\d{3})\.(\d{3})\.(\d{3})(\d)/, "$1.$2.$3-$4")
                .slice(0, 14);
        },

        formatCurrency(value) {
            return value.toLocaleString("pt-BR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            });
        },

        async fetchOffers() {
            this.loading = true;
            this.offers = [];
            this.simulation = null;
            this.error = null;

            try {
                const response = await axios.post(
                    "http://127.0.0.1:8000/api/credit-offer",
                    { cpf: this.cpf.replace(/\D/g, "") }
                );
                this.offers =
                    response.data?.instituicoes?.flatMap((inst) =>
                        inst.modalidades.map((modality) => ({
                            institution: { id: inst.id, name: inst.nome },
                            modality: modality.nome,
                            modality_code: modality.cod,
                        }))
                    ) || [];
            } catch (error) {
                if (error.response && error.response.data.errors) {
                    this.error = Object.values(error.response.data.errors)
                        .flat()
                        .join(" ");
                } else {
                    this.error = "Erro ao buscar ofertas. Tente novamente.";
                }
            } finally {
                this.loading = false;
            }
        },

        async simulateOffer(offer) {
            this.error = null;

            try {
                const response = await axios.post(
                    "http://127.0.0.1:8000/api/credit-simulation",
                    {
                        cpf: this.cpf.replace(/\D/g, ""),
                        institution_id: offer.institution.id,
                        codModalidade: offer.modality_code,
                    }
                );

                if (
                    response.status === 200 &&
                    response.data &&
                    !response.data.error
                ) {
                    this.simulationsHistory[
                        `${offer.institution.id}-${offer.modality_code}`
                    ] = {
                        ...response.data,
                        institution_name: offer.institution.name,
                        modality_name: offer.modality,
                    };

                    this.simulation = response.data;
                    this.renderChart();
                    this.error = null;
                } else {
                    this.error =
                        response.data.error || "Erro ao simular oferta.";
                }
            } catch (error) {
                console.error("Erro ao simular oferta:", error);

                if (error.response && error.response.data.errors) {
                    this.error = Object.values(error.response.data.errors)
                        .flat()
                        .join(" "); // Exibe todos os erros retornados pela API
                } else {
                    this.error = "Erro inesperado ao simular oferta.";
                }
            }
        },

        // Verifica se a oferta já foi simulada
        isSimulated(offer) {
            return !!this.simulationsHistory[
                `${offer.institution.id}-${offer.modality_code}`
            ];
        },

        // Carrega a simulação salva sem consultar API externa
        loadSavedSimulation(offer) {
            const savedSimulation =
                this.simulationsHistory[
                    `${offer.institution.id}-${offer.modality_code}`
                ];
            if (savedSimulation) {
                this.simulation = savedSimulation;
            }
        },

        // Exibe o gráfico apenas com simulações já feitas
        renderChart() {
            this.$nextTick(() => {
                setTimeout(() => {
                    const canvas = document.getElementById("comparisonChart");

                    if (!canvas) {
                        console.error(
                            "Canvas não encontrado! O gráfico não foi renderizado."
                        );
                        return;
                    }

                    const ctx = canvas.getContext("2d");

                    if (this.chartInstance) {
                        this.chartInstance.destroy();
                    }

                    // Filtra apenas as ofertas simuladas para o gráfico
                    const simulatedOffers = Object.values(
                        this.simulationsHistory
                    );

                    if (simulatedOffers.length === 0) {
                        console.warn(
                            "Nenhuma simulação para exibir no gráfico."
                        );
                        return;
                    }

                    this.chartInstance = new Chart(ctx, {
                        type: "bar",
                        data: {
                            labels: simulatedOffers.map(
                                (s) =>
                                    `${s.institution_name} | ${s.modality_name}`
                            ),
                            datasets: [
                                {
                                    label: "Valor Máximo",
                                    backgroundColor: "rgba(75, 192, 192, 0.2)",
                                    borderColor: "rgba(75, 192, 192, 1)",
                                    borderWidth: 1,
                                    data: simulatedOffers.map(
                                        (s) => s.valorMax
                                    ),
                                },
                            ],
                        },
                    });
                }, 300);
            });
        },

        // Exibe gráfico imediatamente ao clicar no botão
        toggleGraph() {
            this.showGraph = !this.showGraph;
            if (this.showGraph) {
                this.renderChart();
            }
        },

        resetSearch() {
            this.cpf = "";
            this.offers = [];
            this.simulation = null;
            this.simulationsHistory = {};
        },
    },
};
</script>
