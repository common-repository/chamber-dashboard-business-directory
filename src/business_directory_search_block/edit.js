import ServerSideRender from '@wordpress/server-side-render';
import { __ } from '@wordpress/i18n';
import { SelectControl, 
    Toolbar,
    Button,
    Tooltip,
    PanelBody,
    PanelRow,
    FormToggle,
    ToggleControl,
    TextControl, 
    ToolbarGroup,
    Disabled, 
    RadioControl,
    RangeControl,
    FontSizePicker } from '@wordpress/components';

    import {
        RichText,
        AlignmentToolbar,
        BlockControls,
        BlockAlignmentToolbar,
        InspectorControls,
        InnerBlocks,
        withColors,
        PanelColorSettings,
        getColorClassName
    } from '@wordpress/editor'
    ;
import { withSelect, widthDispatch } from '@wordpress/data';

const {
    withState
} = wp.compose;

const displayFormatOptions = [
    { label: 'List', value: 'list' },
    { label: 'Responsive', value: 'responsive' },
 ];

const orderbyOptions = [
    { label: 'Title', value: 'title' },
    { label: 'Date', value: 'date' },
    { label: 'Menu Order', value: 'menu_order' },
    { label: 'Random', value: 'rand' },
 ];

const orderOptions = [
    { label: 'Ascending', value: 'asc' },
    { label: 'Descending', value: 'desc' },
];

const imageOptions = [
    { label: 'Logo', value: 'logo' },
    { label: 'Featured Image', value: 'featured' },
    { label: 'None', value: 'none' },
];

const imageSizeOptions = [
    { label: 'Auto', value: '' },
    { label: 'Small', value: 'thumbnail' },
    { label: 'Medium', value: 'medium' },
    { label: 'Large', value: 'large' },
    { label: 'Full Width', value: 'full' },
];

const titleFontSizes = [
    {
        name: __( 'Small' ),
        slug: 'small',
        size: 12,
    },
    {
        name: __( 'Medium' ),
        slug: 'medium',
        size: 18,
    },
    {
        name: __( 'Big' ),
        slug: 'big',
        size: 26,
    },
];
const titleFallbackFontSize = 16;

const edit = props => {
    const {attributes:{searchFormTitleDisplay, searchFormCustomTitle, searchFormAlignment, searchFormLabelDisplay, customSearchFormLabel, categoryFieldDisplay, categoryFieldLabelDisplay, customCategoryFieldLabel, searchInputPlaceholder, searchDisplayFormat, displayDescription, displayMemberLevel, displayCategory, displayTags, displaySocialMedia, displayUrl, displayHours, displayEmail, perPage, orderBy, order, imageType, imageSize, imageAlignment, displayLocationName, displayAddress, displayWebsite, displayPhone, businessTitleFontSize, businessLocationNameFontSize}, className, setAttributes} = props;

    const setResultsPage = selectResultsPage => {
        props.setAttributes( { selectResultsPage} );
    };

    const inspectorControls = (
        <InspectorControls key="inspector">
            <PanelBody title={ __( 'Search Form Options' )}>
                <PanelRow>
                    <label>Search Form Alignment</label>
                    <AlignmentToolbar
                        label = { __('Search Form alignment') }
                        value={ searchFormAlignment }
                        onChange={ ( nextValue ) =>
                            setAttributes( {searchFormAlignment:  nextValue } )
                        }
                    />
                </PanelRow>

                <PanelRow>
                    <ToggleControl
                        label={ __( 'Show Search Form Title' ) }
                        checked={ searchFormTitleDisplay }
                        onChange={ ( nextValue ) =>
                            setAttributes( { searchFormTitleDisplay: nextValue } )
                        }
                    />
                </PanelRow>
                { searchFormTitleDisplay &&
				    (
                        <PanelRow>
                            <TextControl
                                label="Custom Search Form Title"
                                value={ searchFormCustomTitle }
                                onChange={ ( nextValue ) =>
                                    setAttributes( { searchFormCustomTitle: nextValue } )
                                }
                            />
                        </PanelRow>
                    )
                }
                <PanelRow>
                    <ToggleControl
                        label={ __( 'Show Search Form Label' ) }
                        checked={ searchFormLabelDisplay }
                        onChange={ ( nextValue ) =>
                            setAttributes( { searchFormLabelDisplay: nextValue } )
                        }
                    />
                </PanelRow>
                { searchFormLabelDisplay &&
				    (
                        <PanelRow>
                            <TextControl
                                label="Custom Search Form Label"
                                value={ customSearchFormLabel }
                                onChange={ ( nextValue ) =>
                                    setAttributes( { customSearchFormLabel: nextValue } )
                                }
                            />
                        </PanelRow>
                    )
                }
                <PanelRow>
                    <TextControl
                        label="Search Form Placeholder"
                        value={ searchInputPlaceholder }
                        onChange={ ( nextValue ) =>
                            setAttributes( { searchInputPlaceholder: nextValue } )
                        }
                    />
                </PanelRow>
                <PanelRow>
                    <ToggleControl
                    label={ __( 'Show Category Field' ) }
                        checked={ categoryFieldDisplay }
                        onChange={ ( nextValue ) =>
                            setAttributes( { categoryFieldDisplay: nextValue } )
                        }
                    />
                </PanelRow>
                <PanelRow>
                    
                </PanelRow>
                { categoryFieldDisplay &&
				    (
                        <PanelRow>
                            <ToggleControl
                            label={ __( 'Show Category Field Label' ) }
                            checked={ 
                                categoryFieldLabelDisplay }
                            onChange={ ( nextValue ) =>
                                setAttributes( { categoryFieldLabelDisplay: nextValue } )
                            }
                        />
                        </PanelRow>
                    )
                }
                { categoryFieldDisplay &&
				    (
                        <PanelRow>
                            { categoryFieldLabelDisplay && (
                                    <TextControl
                                    label="Custom Category Label"
                                    value={ customCategoryFieldLabel }
                                    onChange={ ( nextValue ) =>
                                        setAttributes( { customCategoryFieldLabel: nextValue } )
                                    }
                                />
                                ) 
                            }
                            
                        </PanelRow>
                    )
                }

            </PanelBody>
            <PanelBody title={ __( 'Search Results Options' )} initialOpen={ false }>
                <PanelRow>
                    <SelectControl
                        label="Search Results Layout"
                        value={searchDisplayFormat}
                        options= { displayFormatOptions }
                        onChange={ ( nextValue ) =>
                            setAttributes( { searchDisplayFormat:  nextValue } )
                        }
                    />        
                </PanelRow>
                <PanelRow>
                    <RangeControl
                        label="Number of Businesses per page"
                        min={-1 }
                        max={ 50 }
                        value={ perPage }
                        onChange={ ( value ) => setAttributes( { perPage: value} ) }
                        initialPosition = { -1 }
                        //allowReset = { true }
                        //resetFallbackValue = { -1 }
                    />
                </PanelRow>
                <PanelRow>
                    <SelectControl
                        label="Order By:"
                        value={orderBy}
                        options= { orderbyOptions }
                        onChange={ ( nextValue ) =>
                            setAttributes( { orderBy:  nextValue } )
                        }
                    />        
                </PanelRow>
                <PanelRow>
                    <SelectControl
                        label="Order"
                        value={order}
                        options= { orderOptions }
                        onChange={ ( nextValue ) =>
                            setAttributes( { order:  nextValue } )
                        }
                    />        
                </PanelRow>
                <PanelRow>Business Title Font Size</PanelRow>
                <PanelRow>
                    <FontSizePicker
                        fontSizes={ titleFontSizes }
                        value={ businessTitleFontSize }
                        fallbackFontSize={ titleFallbackFontSize }
                        withSlider= "true"
                        onChange={ ( nextValue ) =>
                            setAttributes( {businessTitleFontSize:  nextValue } )
                        }
                    />
                </PanelRow>
                <PanelRow>Location Name Font Size</PanelRow>
                <PanelRow>
                    <FontSizePicker
                        fontSizes={ titleFontSizes }
                        value={ businessLocationNameFontSize }
                        fallbackFontSize={ titleFallbackFontSize }
                        withSlider= "true"
                        onChange={ ( nextValue ) =>
                            setAttributes( {businessLocationNameFontSize:  nextValue } )
                        }
                    />
                </PanelRow>
            </PanelBody>
            <PanelBody title={ __( 'Search Results Image Options' )} initialOpen={ false }>
                <PanelRow>
                    <SelectControl
                        label="Image Display Options"
                        value={imageType}
                        options= { imageOptions }
                        onChange={ ( nextValue ) =>
                            setAttributes( { imageType:  nextValue } )
                        }
                    />
                </PanelRow>
                <PanelRow>
                    <SelectControl
                        label="Image Size"
                        value={imageSize}
                        options= { imageSizeOptions }
                        onChange={ ( nextValue ) =>
                            setAttributes( { imageSize:  nextValue } )
                        }
                    />
                </PanelRow>
            </PanelBody>
            <PanelBody title={ __( 'Search Results Display Options' )} initialOpen={ false }>
                <PanelRow>
                    <ToggleControl
                        label={ __( 'Display Description' ) }
                        checked={ displayDescription }
                        onChange={ ( nextValue ) =>
                            setAttributes( { displayDescription:  nextValue } )
                        }
                    />
                </PanelRow>
                <PanelRow>
                    <ToggleControl
                        label={ __( 'Display Membership Level' ) }
                        checked={ displayMemberLevel }
                        onChange={ ( nextValue ) =>
                            setAttributes( { displayMemberLevel:  nextValue } )
                        }
                    />
                </PanelRow>
                <PanelRow>
                    <ToggleControl
                        label={ __( 'Display Business Categories' ) }
                        checked={ displayCategory }
                        onChange={ ( nextValue ) =>
                            setAttributes( { displayCategory:  nextValue } )
                        }
                    />
                </PanelRow>
                <PanelRow>
                    <ToggleControl
                        label={ __( 'Display Business Tags' ) }
                        checked={ displayTags }
                        onChange={ ( nextValue ) =>
                            setAttributes( { displayTags:  nextValue } )
                        }
                    />
                </PanelRow>
                <PanelRow>
                    <ToggleControl
                        label={ __( 'Display Social Media Icons' ) }
                        checked={ displaySocialMedia }
                        onChange={ ( nextValue ) =>
                            setAttributes( { displaySocialMedia:  nextValue } )
                        }
                    />
                </PanelRow>
                <PanelRow>
                    <ToggleControl
                        label={ __( 'Display Location Name' ) }
                        checked={ displayLocationName }
                        onChange={ ( nextValue ) =>
                            setAttributes( { displayLocationName:  nextValue } )
                        }
                    />
                </PanelRow>
                <PanelRow>
                    <ToggleControl
                        label={ __( 'Display Address' ) }
                        checked={ displayAddress }
                        onChange={ ( nextValue ) =>
                            setAttributes( { displayAddress:  nextValue } )
                        }
                    />
                </PanelRow>
                <PanelRow>
                    <ToggleControl
                        label={ __( 'Display Url' ) }
                        checked={ displayWebsite }
                        onChange={ ( nextValue ) =>
                            setAttributes( { displayWebsite:  nextValue } )
                        }
                    />
                </PanelRow>
                <PanelRow>
                    <ToggleControl
                        label={ __( 'Display Business Hours' ) }
                        checked={ displayHours }
                        onChange={ ( nextValue ) =>
                            setAttributes( { displayHours:  nextValue } )
                        }
                    />
                </PanelRow>
                <PanelRow>
                    <ToggleControl
                        label={ __( 'Display Phone Number' ) }
                        checked={ displayPhone }
                        onChange={ ( nextValue ) =>
                            setAttributes( { displayPhone:  nextValue } )
                        }
                    />
                </PanelRow>
                <PanelRow>
                    <ToggleControl
                        label={ __( 'Display Emails' ) }
                        checked={ displayEmail }
                        onChange={ ( nextValue ) =>
                            setAttributes( { displayEmail:  nextValue } )
                        }
                    />
                </PanelRow>
            </PanelBody>
        </InspectorControls>
    );
    return [
        <div className={ props.className }>
            <ServerSideRender
                block="cdash-bd-blocks/business-directory-search"
                attributes = {props.attributes}
            />
            { inspectorControls }
            <div className="business_search">
                
            </div>
        </div>
    ];

};

export default edit;
