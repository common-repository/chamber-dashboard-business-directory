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
    ToolbarGroup,
    Disabled, 
    RadioControl,
    RangeControl,
    FontSizePicker,
    ColorPicker,
    ColorPalette,
} from '@wordpress/components';

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
    } from '@wordpress/block-editor'
    ;
import { withSelect, widthDispatch } from '@wordpress/data';

import { withState } from '@wordpress/compose';

const formatOptions = [
    { label: 'List', value: 'list' },
    { label: '2 Columns', value: 'grid2' },
    { label: '3 Columns', value: 'grid3' },
    { label: '4 Columns', value: 'grid4' },
    { label: 'Responsive', value: 'responsive' },
 ];
const textOptions = [
    { label: 'Excerpt', value: 'excerpt' },
    { label: 'Description', value: 'description' },
    { label: 'None', value: 'none' },
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
const categoryOptions = [
    { label: 'Select one or more categories', value: null }
];

const borderStyleOptions = [
    { label: 'Solid', value: 'solid' },
    { label: 'Dotted', value: 'dotted' },
    { label: 'Dashed', value: 'dashed' },
    { label: 'Double', value: 'double' },
];

wp.apiFetch({path: "/wp/v2/business_category?per_page=100"}).then(posts => {
    jQuery.each( posts, function( key, val ) {
        categoryOptions.push({label: val.name, value: val.slug});
    });
}).catch( 

)

const membershipLevelOptions = [
    { label: 'Select one or more Membersihp Levels', value: null }
];

const membershipStatusOptions = [
    //{ label: 'Select a Membership Status', value: null }
];

var fetchUrlAction = wpAjax.wpurl+'/wp-admin/admin-ajax.php?action=cdash_check_mm_active_action';


wp.apiFetch({url: fetchUrlAction}).then(response => {
    if(response.cdash_mm_active){
        wp.apiFetch({path: "/wp/v2/membership_status?per_page=100"}).then(posts => {
            jQuery.each( posts, function( key, val ) {
                membershipStatusOptions.push({label: val.name, value: val.slug});
            });
        });
    }
});

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

const borderRadiusUnitOptions = [
    { label: 'px', value: 'px' },
    { label: '%', value: '%' },
];

wp.apiFetch({path: "/wp/v2/membership_level?per_page=100"}).then(posts => {
    jQuery.each( posts, function( key, val ) {
        membershipLevelOptions.push({label: val.name, value: val.slug});
    });
});


const edit = props => {
    const {attributes: {align, textAlignment, cd_block, postLayout, format, categoryArray, category, tags, membershipLevelArray, level, displayPostContent, display, text, singleLinkToggle, single_link, perpage, orderby, order, image, membershipStatusArray, status, image_size, alphaToggle, alpha, logo_gallery, categoryFilterToggle,  show_category_filter, displayAddressToggle, displayUrlToggle, displayPhoneToggle, displayEmailToggle, displayCategoryToggle, displayTagsToggle, displayLevelToggle, displaySocialMediaIconsToggle, displayLocationNameToggle, displayHoursToggle, changeTitleFontSize, titleFontSize, disablePagination, displayImageOnTop, enableBorder, borderColor, borderThickness, borderStyle, borderRadius, borderRadiusUnits}, className, setAttributes } = props;

    const setDirectoryLayout = format => {
        props.setAttributes( { format } );
    };

    const setCategories = categoryArray => {
        props.setAttributes( { categoryArray} );
    };

    const setMembershipLevel = membershipLevelArray => {
        props.setAttributes( { membershipLevelArray} );
    };

    const setMembershipStatus = membershipStatusArray => {
        props.setAttributes( { membershipStatusArray} );
    };

    const setSingleLink = singleLinkToggle =>{
        props.setAttributes({singleLinkToggle})
        !! singleLinkToggle ? __( props.setAttributes({single_link: 'yes'}) ) : __( props.setAttributes({single_link: 'no'}) );
        
    };
    const setAlpha = alphaToggle =>{
        props.setAttributes({alphaToggle})
        !! alphaToggle ? __( props.setAttributes({alpha: 'yes'}) ) : __( props.setAttributes({alpha: 'no'}) );
        
    };
    const setShowCategoryFilter = categoryFilterToggle =>{
        props.setAttributes({categoryFilterToggle})
        !! categoryFilterToggle ? __( props.setAttributes({show_category_filter: 'yes'}) ) : __( props.setAttributes({show_category_filter: 'no'}) );
        
    };

    const inspectorControls = (
        <InspectorControls key="inspector">
            <PanelBody title={ __( 'Formatting Options' )}>
                <PanelRow>
                    <SelectControl
                        label="Directory Layout"
                        value={ format }
                        options= { formatOptions }
                        onChange = {setDirectoryLayout}
                    />
                </PanelRow>
                <PanelRow>
                <RangeControl
                    label="Number of Businesses per page"
                    min={-1 }
                    max={ 50 }
                    onChange={ ( value ) => setAttributes( { perpage: value} ) }
                    value={ perpage }
                    initialPosition = { -1 }
                    allowReset = "true"
                />
                </PanelRow>
                <PanelRow>
                    <ToggleControl
                        label={ __( 'Disable Pagination' ) }
                        checked={ disablePagination }
                        //onChange = {setDisplayAddressToggle}
                        onChange={ ( nextValue ) =>
                            setAttributes( { disablePagination:  nextValue } )
                        }
                    />
                </PanelRow>
                <PanelRow>
                    <ToggleControl
                        label={ __( 'Display Title below the Image' ) }
                        checked={ displayImageOnTop }
                        onChange={ ( nextValue ) =>
                            setAttributes( { displayImageOnTop:  nextValue } )
                        }
                    />
                </PanelRow>
                <PanelRow>
                    <ToggleControl
                        label={ __( 'Enable Custom Title Font size' ) }
                        checked={ changeTitleFontSize }
                        //onChange = {setDisplayAddressToggle}
                        onChange={ ( nextValue ) =>
                            setAttributes( { changeTitleFontSize:  nextValue } )
                        }
                    />
                </PanelRow>
                    { changeTitleFontSize &&
						 (  
                            <PanelRow>
                                <FontSizePicker
                                    fontSizes={ titleFontSizes }
                                    value={ titleFontSize }
                                    fallbackFontSize={ titleFallbackFontSize }
                                    withSlider= "true"
                                    onChange={ ( nextValue ) =>
                                        setAttributes( {titleFontSize:  nextValue } )
                                    }
                                />
                            </PanelRow>
					) }
                <PanelRow>
                    <ToggleControl
                        label={ __( 'Enable Border Styles' ) }
                        checked={ enableBorder }
                        onChange={ ( nextValue ) =>
                            setAttributes( { enableBorder:  nextValue } )
                        }
                    />
                </PanelRow>
                { enableBorder && (
                    /*<ColorPalette
                        colors={ colors }
                        value={ borderColor }
                        onChange={ ( color ) => setState( { color } ) }
                    />*/
                    /*<ColorPicker
                        label="Border Color"
                        color={ borderColor }
                        onChangeComplete={ ( value ) => setState( value.hex ) }
                    />*/
                    <PanelColorSettings
                        title={ __( 'Color Settings' ) }
                        colorSettings={ [
                            {
                                value: borderColor,
                                onChange: ( colorValue ) => setAttributes( { borderColor: colorValue } ),
                                label: __( 'Border Color' ),
                            },
                        ] }
                    />
                )}
                { enableBorder &&
                (  
                    <PanelRow>
                        <RangeControl
                            label="Border Thickness"
                            min={1 }
                            max={ 10 }
                            onChange={ ( value ) => setAttributes( { borderThickness: value} ) }
                            value={ borderThickness }
                            initialPosition = { 1 }
                            allowReset = "true"
                        />
                    </PanelRow>
                ) }
                { enableBorder &&
                (
                    <SelectControl
                        label="Border Style"
                        value={borderStyle}
                        options= { borderStyleOptions }
                        onChange={ ( nextValue ) =>
                            setAttributes( {borderStyle:  nextValue } )
                        }
                    />
                )}
                { enableBorder &&
                (  
                    <PanelRow>
                        <RangeControl
                            label="Border Radius"
                            min={0 }
                            max={ 100 }
                            onChange={ ( value ) => setAttributes( { borderRadius: value} ) }
                            value={ borderRadius }
                            initialPosition = { 0 }
                            allowReset = "true"
                        />
                    </PanelRow>
                ) }
                { enableBorder &&
                (
                    <SelectControl
                        label="Border Radius Units"
                        value={borderRadiusUnits}
                        options= { borderRadiusUnitOptions }
                        onChange={ ( nextValue ) =>
                            setAttributes( {borderRadiusUnits:  nextValue } )
                        }
                    />
                )}
                <PanelRow>
                    <SelectControl
                        label="Order By"
                        value={orderby}
                        options= { orderbyOptions }
                        onChange={ ( nextValue ) =>
                            setAttributes( {orderby:  nextValue } )
                        }
                    />
                </PanelRow>
                <PanelRow>
                    <SelectControl
                        label="Order"
                        value={order}
                        options= { orderOptions }
                        onChange={ ( nextValue ) =>
                            setAttributes( {order:  nextValue } )
                        }
                    />
                </PanelRow>
            </PanelBody>
            <PanelBody title={ __( 'Display Options' )} initialOpen={ false }>
                <PanelRow>
                    <ToggleControl
                        label={ __( 'Display Address' ) }
                        checked={ displayAddressToggle }
                        onChange={ ( nextValue ) =>
                            setAttributes( { displayAddressToggle: nextValue } )
                        }
                    />
                </PanelRow>
                <PanelRow>
                    <ToggleControl
                        label={ __( 'Display Url' ) }
                        checked={ displayUrlToggle }
                        onChange={ ( nextValue ) =>
                            setAttributes( { displayUrlToggle: nextValue } )
                        }
                    />
                </PanelRow>
                    <PanelRow>
                        <ToggleControl
                            label={ __( 'Display Phone' ) }
                            checked={ displayPhoneToggle }
                            onChange={ ( nextValue ) =>
                                setAttributes( { displayPhoneToggle: nextValue } )
                            }
                        />
                    </PanelRow>
                    <PanelRow>
                        <ToggleControl
                            label={ __( 'Display Email' ) }
                            checked={ displayEmailToggle }
                            onChange={ ( nextValue ) =>
                                setAttributes( { displayEmailToggle:  nextValue } )
                            }
                        />
                    </PanelRow>
                    <PanelRow>
                        <ToggleControl
                            label={ __( 'Display Location Name' ) }
                            checked={ displayLocationNameToggle }
                            onChange={ ( nextValue ) =>
                                setAttributes( { displayLocationNameToggle:  nextValue } )
                            }
                        />
                    </PanelRow>
                    <PanelRow>
                        <ToggleControl
                            label={ __( 'Display Categories' ) }
                            checked={ displayCategoryToggle }
                            onChange={ ( nextValue ) =>
                                setAttributes( { displayCategoryToggle:  nextValue } )
                            }
                        />
                    </PanelRow>
                    <PanelRow>
                        <ToggleControl
                            label={ __( 'Display Tags' ) }
                            checked={ displayTagsToggle }
                            onChange={ ( nextValue ) =>
                                setAttributes( { displayTagsToggle:  nextValue } )
                            }
                        />
                    </PanelRow>
                    <PanelRow>
                        <ToggleControl
                            label={ __( 'Display Membersihp Level' ) }
                            checked={ displayLevelToggle }
                            onChange={ ( nextValue ) =>
                                setAttributes( { displayLevelToggle:  nextValue } )
                            }
                        />
                    </PanelRow>
                    <PanelRow>
                        <ToggleControl
                            label={ __( 'Display Social Media Icons' ) }
                            checked={ displaySocialMediaIconsToggle }
                            onChange={ ( nextValue ) =>
                                setAttributes( { displaySocialMediaIconsToggle:  nextValue } )
                            }
                        />
                    </PanelRow>
                    <PanelRow>
                        <ToggleControl
                            label={ __( 'Display Hours' ) }
                            checked={ displayHoursToggle }
                            onChange={ ( nextValue ) =>
                                setAttributes( { displayHoursToggle:  nextValue } )
                            }
                        />
                    </PanelRow>
            </PanelBody>
            <PanelBody title={ __( 'Content Settings' )} initialOpen={ false }>
                <PanelRow>
                    <SelectControl
                        label="Post Content"
                        value={ text }
                        options= { textOptions }
                        onChange={ ( nextValue ) =>
                            setAttributes( { text:  nextValue } )
                        }
                    />
                </PanelRow>        
                <PanelRow>
                    <ToggleControl
						label={ __( 'Enable click-thru to individual listing' ) }
						checked={ singleLinkToggle }
                        onChange = {setSingleLink}
					/>
                </PanelRow>
            </PanelBody>
            <PanelBody title={ __( 'Image Settings' )} initialOpen={ false }>
                <PanelRow>
                    <SelectControl
                        label="Type of Image"
                        value={image}
                        options= { imageOptions }
                        onChange={ ( nextValue ) =>
                            setAttributes( { image:  nextValue } )
                        }
                    />
                </PanelRow>
                <PanelRow>
                    <SelectControl
                        label="Image Size"
                        value={image_size}
                        options= { imageSizeOptions }
                        onChange={ ( nextValue ) =>
                            setAttributes( { image_size:  nextValue } )
                        }
                    />
                </PanelRow>
            </PanelBody>
            <PanelBody title={ __( 'Limit By:' )} initialOpen={ false }>
                <PanelRow>
                    <SelectControl 
                        multiple
                        className = "cdash_multi_select"
                        label = "Categories"
                        value = {categoryArray}
                        options = {categoryOptions}
                        onChange = {setCategories}
                    />
                </PanelRow>
                <PanelRow>
                    <SelectControl 
                        multiple
                        className = "cdash_multi_select"
                        label = "Membership Level"
                        value = {membershipLevelArray}
                        options = {membershipLevelOptions}
                        onChange = {setMembershipLevel}
                    />
                </PanelRow>
                <PanelRow>
                    <SelectControl 
                        multiple
                        className = "cdash_multi_select"
                        label = "Membership Status"
                        value = {membershipStatusArray}
                        options = {membershipStatusOptions}
                        onChange = {setMembershipStatus}
                    />
                </PanelRow>
            </PanelBody>
            <PanelBody title={ __( 'Additional Options' )} initialOpen={ false }>
                <PanelRow>
                    <ToggleControl
						label={ __( 'Enable Alpha Search' ) }
						checked={ alphaToggle }
                        onChange = {setAlpha}
					/>
                </PanelRow>
                <PanelRow>
                    <ToggleControl
						label={ __( 'Enable Filter by Category' ) }
						checked={ categoryFilterToggle }
                        onChange = {setShowCategoryFilter}
                        help={ !! categoryFilterToggle ? __( 'Show the filter by category option' ) : __( 'Hide the filter by category option.' ) }
					/>
                </PanelRow>
                
            </PanelBody>
            
        </InspectorControls>
    );
    const alignmentControls = (
        <BlockControls>
            <AlignmentToolbar
                value={textAlignment}
                onChange={(newalign) => setAttributes({ textAlignment: newalign })}
            />
        </BlockControls>
    );
    return [
        <div className={ props.className }>
            <ServerSideRender
                block="cdash-bd-blocks/business-directory"
                attributes = {props.attributes}
            />
            { alignmentControls }
            { inspectorControls }
            <div className="businesslist">
                
            </div>
        </div>
    ];
};

export default edit;


