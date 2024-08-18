import { SubFetureCalculatorTariff } from './sub-features';

class FeatureCalculatorTariff {
  alias = 'calculator_tariff';
  constructor(moduleAlias: string) {
    this.alias = `${moduleAlias}-${this.alias}`;
  }

  get calculator() {
    return new SubFetureCalculatorTariff(this.alias);
  }
}

export class CalculatorTariffPrivilege {
  alias = 'app_calculator_tariff';
  calculatorTariff = new FeatureCalculatorTariff(this.alias);
}
