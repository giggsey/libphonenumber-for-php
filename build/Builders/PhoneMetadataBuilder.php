<?php

declare(strict_types=1);

namespace libphonenumber\buildtools\Builders;

use libphonenumber\NumberFormat;
use libphonenumber\PhoneMetadata;
use libphonenumber\PhoneNumberDesc;
use Nette\PhpGenerator\ClassManipulator;
use Nette\PhpGenerator\Dumper;
use Nette\PhpGenerator\PhpFile;
use ReflectionClass;
use Exception;
use RuntimeException;

/**
 * @internal
 */
class PhoneMetadataBuilder extends PhoneMetadata
{
    /**
     * These are constants we want to create in toFile())
     * @var array<string,mixed>
     */
    private array $constants = [];

    public function setId(string $value): static
    {
        $this->constants['ID'] = $value;
        return $this;
    }

    public function setCountryCode(int $value): static
    {
        $this->constants['COUNTRY_CODE'] = $value;
        return $this;
    }

    /**
     * Only used for metadata generation
     */
    public function getCountryCode(): ?int
    {
        return $this->constants['COUNTRY_CODE'] ?? null;
    }

    /**
     * Only used for metadata generation
     */
    public function getId(): ?string
    {
        return $this->constants['ID'] ?? null;
    }

    public function setLeadingDigits(string $value): static
    {
        $this->constants['LEADING_DIGITS'] = $value;
        return $this;
    }

    /**
     * Only used for metadata generation
     */
    public function getLeadingDigits(): ?string
    {
        return $this->constants['LEADING_DIGITS'] ?? null;
    }

    public function setPreferredInternationalPrefix(string $value): static
    {
        $this->preferredInternationalPrefix = $value;
        return $this;
    }

    public function setNationalPrefixForParsing(string $value): static
    {
        $this->nationalPrefixForParsing = $value;
        return $this;
    }

    public function setNationalPrefixTransformRule(string $value): static
    {
        $this->nationalPrefixTransformRule = $value;
        return $this;
    }

    public function setNationalPrefix(string $value): static
    {
        $this->constants['NATIONAL_PREFIX'] = $value;
        return $this;
    }

    /**
     * Only used for metadata generation
     */
    public function getNationalPrefix(): ?string
    {
        return $this->constants['NATIONAL_PREFIX'] ?? null;
    }

    public function setPreferredExtnPrefix(string $value): static
    {
        $this->preferredExtnPrefix = $value;
        return $this;
    }

    public function setMainCountryForCode(bool $value): static
    {
        $this->mainCountryForCode = $value;
        return $this;
    }

    public function setMobileNumberPortableRegion(bool $value): static
    {
        $this->mobileNumberPortableRegion = $value;
        return $this;
    }

    public function addNumberFormat(NumberFormat $value): static
    {
        $this->numberFormat[] = $value;
        return $this;
    }

    public function addIntlNumberFormat(NumberFormat $value): static
    {
        $this->intlNumberFormat[] = $value;
        return $this;
    }

    public function clearIntlNumberFormat(): static
    {
        $this->intlNumberFormat = [];
        return $this;
    }

    // Add missing setters from PhoneMetadata
    public function setGeneralDesc(PhoneNumberDesc $value): static
    {
        $this->generalDesc = $value;
        return $this;
    }

    public function setFixedLine(PhoneNumberDesc $value): static
    {
        $this->fixedLine = $value;
        return $this;
    }

    public function setMobile(PhoneNumberDesc $value): static
    {
        $this->mobile = $value;
        return $this;
    }

    public function setTollFree(PhoneNumberDesc $value): static
    {
        $this->tollFree = $value;
        return $this;
    }

    public function setPremiumRate(PhoneNumberDesc $value): static
    {
        $this->premiumRate = $value;
        return $this;
    }

    public function setSharedCost(PhoneNumberDesc $value): static
    {
        $this->sharedCost = $value;
        return $this;
    }

    public function setPersonalNumber(PhoneNumberDesc $value): static
    {
        $this->personalNumber = $value;
        return $this;
    }

    public function setVoip(PhoneNumberDesc $value): static
    {
        $this->voip = $value;
        return $this;
    }

    public function setPager(PhoneNumberDesc $value): static
    {
        $this->pager = $value;
        return $this;
    }

    public function setUan(PhoneNumberDesc $value): static
    {
        $this->uan = $value;
        return $this;
    }

    public function setEmergency(PhoneNumberDesc $value): static
    {
        $this->emergency = $value;
        return $this;
    }

    public function setVoicemail(PhoneNumberDesc $value): static
    {
        $this->voicemail = $value;
        return $this;
    }

    public function setShortCode(PhoneNumberDesc $value): static
    {
        $this->short_code = $value;
        return $this;
    }

    public function setStandardRate(PhoneNumberDesc $value): static
    {
        $this->standard_rate = $value;
        return $this;
    }

    public function setCarrierSpecific(PhoneNumberDesc $value): static
    {
        $this->carrierSpecific = $value;
        return $this;
    }

    public function setSmsServices(PhoneNumberDesc $value): static
    {
        $this->smsServices = $value;
        return $this;
    }

    public function setNoInternationalDialling(PhoneNumberDesc $value): static
    {
        $this->noInternationalDialling = $value;
        return $this;
    }

    public function setSameMobileAndFixedLinePattern(bool $value): static
    {
        $this->sameMobileAndFixedLinePattern = $value;
        return $this;
    }

    public function toFile(string $className, string $namespaceName): PhpFile
    {
        $dumper = new Dumper();

        $file = new PhpFile();
        $file->setStrictTypes();

        $namespace = $file->addNamespace($namespaceName);
        $namespace->addUse(PhoneMetadata::class);
        $namespace->addUse(NumberFormat::class);
        $namespace->addUse(PhoneNumberDesc::class);

        $class = $namespace->addClass($className);
        $class->addComment('@internal');
        $class->setExtends(PhoneMetadata::class);

        $manipulator = new ClassManipulator($class);
        $parentReflection = new ReflectionClass(PhoneMetadata::class);
        $reflection = new ReflectionClass($this);

        $constructor = $class->addMethod('__construct');

        foreach ($reflection->getConstants() as $name => $value) {
            $parentConstant = $parentReflection->getConstant($name);
            $parentValue = $parentConstant?->getValue();

            if ($parentValue !== $value) {
                $constant = $class->addConstant($name, $value);
                $constant->setProtected();
            }
        }

        foreach ($this->constants as $name => $value) {
            $parentConstant = $parentReflection->getConstant($name);
            $parentValue = $parentConstant?->getValue();

            if ($class->hasConstant($name)) {
                $class->getConstant($name)->setValue($value);
            } else {
                $constant = $class->addConstant($name, $value);
                $constant->setProtected();
            }

            if ($parentValue === $value) {
                // Same value as the parent, remove it to inherit
                $class->removeConstant($name);
            }
        }

        foreach ($reflection->getProperties() as $property) {
            if (!$property->isInitialized($this)) {
                // Skip uninitialized properties
                continue;
            }

            if ($property->isPrivate()) {
                // Skip private properties, these are only used by the builder itself
                continue;
            }

            $propertyValue = $property->getValue($this);

            // Check parent class for the property value
            $parentProperty = $parentReflection->getProperty($property->getName());
            $parentValue = $parentProperty->getDefaultValue();

            if ($propertyValue !== $parentValue) {
                $newProperty = $manipulator->inheritProperty($property->getName());

                if (is_scalar($propertyValue) || is_null($propertyValue)) {
                    $newProperty->setValue($propertyValue);
                } elseif (is_array($propertyValue)) {
                    $items = [];
                    foreach ($propertyValue as $value) {
                        if (!$value instanceof NumberFormat) {
                            throw new Exception('Unsupported type: ' . gettype($value));
                        }

                        $thisItem = ['(new NumberFormat())'];

                        $thisItem[] = sprintf("\t->setPattern(%s)", $dumper->dump($value->getPattern()));
                        $thisItem[] = sprintf("\t->setFormat(%s)", $dumper->dump($value->getFormat()));
                        $thisItem[] = sprintf("\t->setLeadingDigitsPattern(%s)", $dumper->dump($value->leadingDigitPatterns()));

                        if ($value->hasNationalPrefixFormattingRule() && $value->getNationalPrefixFormattingRule() !== '') {
                            $thisItem[] = sprintf("\t->setNationalPrefixFormattingRule(%s)", $dumper->dump($value->getNationalPrefixFormattingRule()));
                        }

                        if ($value->hasDomesticCarrierCodeFormattingRule() && $value->getDomesticCarrierCodeFormattingRule() !== '') {
                            $thisItem[] = sprintf("\t->setDomesticCarrierCodeFormattingRule(%s)", $dumper->dump($value->getDomesticCarrierCodeFormattingRule()));
                        }

                        if ($value->hasNationalPrefixOptionalWhenFormatting()) {
                            $thisItem[] = sprintf("\t->setNationalPrefixOptionalWhenFormatting(%s)", $dumper->dump($value->getNationalPrefixOptionalWhenFormatting()));
                        }

                        $thisItem[count($thisItem) - 1] .= ',';

                        $items[] = $thisItem;
                    }

                    if (count($items) > 0) {
                        $constructor->addBody('$this->? = [', [$property->getName()]);
                        foreach ($items as $index => $item) {
                            $constructor->addBody(implode("\n", $item));
                        }
                        $constructor->addBody('];');

                        $class->removeProperty($property->getName());
                    }
                } else {
                    // We need to do this in the constructor instead
                    $class->removeProperty($property->getName());

                    if (!$propertyValue instanceof PhoneNumberDesc) {
                        throw new RuntimeException('Unsupported type: ' . gettype($propertyValue));
                    }

                    $chained = [];

                    if ($propertyValue->hasNationalNumberPattern()) {
                        $chained[] = ['->setNationalNumberPattern(?)', ['pattern' => $propertyValue->getNationalNumberPattern()]];
                    }

                    if ($propertyValue->hasExampleNumber()) {
                        $chained[] = ['->setExampleNumber(?)', [$propertyValue->getExampleNumber()]];
                    }

                    if ($propertyValue->getPossibleLengthLocalOnly() !== []) {
                        $chained[] = ['->setPossibleLengthLocalOnly(?)', [$propertyValue->getPossibleLengthLocalOnly()]];
                    }

                    if (count($chained) === 0 && $propertyValue->getPossibleLength() === [-1]) {
                        // Our PhoneNumberDesc is empty, use the shortcut
                        $constructor->addBody(sprintf('$this->%s = PhoneNumberDesc::empty();', $property->getName()));
                        continue;
                    }

                    if ($propertyValue->getPossibleLength() !== []) {
                        $chained[] = ['->setPossibleLength(?)', [$propertyValue->getPossibleLength()]];
                    }

                    if (count($chained) > 0) {
                        $constructor->addBody(sprintf('$this->%s = (new PhoneNumberDesc())', $property->getName()));

                        $totalChained = count($chained);
                        foreach ($chained as $index => $chain) {
                            $isLast = ($index === $totalChained - 1);
                            $constructor->addBody("\t" . $chain[0] . ($isLast ? ';' : ''), $chain[1]);
                        }
                    }
                }
            }
        }

        if ($constructor->getBody() === '') {
            $class->removeMethod($constructor->getName());
        }

        return $file;
    }
}
