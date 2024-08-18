export class SubFetureCalculatorTariff {
    alias = '';
    constructor(featureAlias: string) {
      this.alias = featureAlias;
    }

    get readCalculatorTariff() {
      return `${this.alias}-read_calculator_tariff`;
    }
  }
