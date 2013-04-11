<?php
/**
 * Used by Container to test creating object with
 * type-hinted dependency
 */
class ObjectWithDependency {
    public function __construct(ObjectCreatedByContainer $ocbc) {}
}
?>
